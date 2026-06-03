<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected string $gateway;
    protected array  $config;

    public function __construct(string $gateway = '')
    {
        // Use provided gateway or fall back to first active gateway
        $this->gateway = $gateway ?: $this->defaultGateway();
        $this->config  = $this->loadConfig($this->gateway);
    }

    // ─────────────────────────────────────────────────────────────
    // Gateway registry
    // ─────────────────────────────────────────────────────────────

    /**
     * Return all enabled gateways as ['key' => 'label'].
     */
    public static function activeGateways(): array
    {
        $all = [
            'zarinpal' => 'زرین‌پال',
            'zibal'    => 'زیبال',
            'payping'  => 'پی‌پینگ',
        ];

        $active = Setting::get('active_gateways', '');
        if ($active) {
            $decoded = is_array($active) ? $active : json_decode($active, true);
            if (!empty($decoded)) {
                return array_intersect_key($all, array_flip($decoded));
            }
        }

        // Fallback: legacy single gateway setting
        $legacy = Setting::get('payment_gateway', '');
        if ($legacy && isset($all[$legacy])) {
            return [$legacy => $all[$legacy]];
        }

        return [];
    }

    protected function defaultGateway(): string
    {
        $gateways = static::activeGateways();
        return array_key_first($gateways) ?? '';
    }

    protected function loadConfig(string $gateway): array
    {
        return match ($gateway) {
            'zarinpal' => [
                'merchant' => Setting::get('zarinpal_merchant', ''),
                'sandbox'  => (bool) Setting::get('zarinpal_sandbox', false),
            ],
            'zibal' => [
                'merchant' => Setting::get('zibal_merchant', ''),
            ],
            'payping' => [
                'token' => Setting::get('payping_token', ''),
            ],
            default => [],
        };
    }

    // ─────────────────────────────────────────────────────────────
    // Public API
    // ─────────────────────────────────────────────────────────────

    /**
     * Create a payment record and return redirect URL to gateway.
     */
    public function request(array $data): array
    {
        if (empty($this->gateway)) {
            return ['success' => false, 'message' => 'هیچ درگاه پرداختی فعال نیست.'];
        }

        $callbackUrl = $data['callback_url'] ?? route('payment.verify');

        $payment = Payment::create([
            'user_id'         => $data['user_id'],
            'amount'          => $data['amount'],
            'tax_amount'      => $data['tax_amount'] ?? 0,
            'fee_amount'      => $data['fee_amount'] ?? 0,
            'gateway'         => $this->gateway,
            'payment_type'    => $data['payment_type'],
            'payable_type'    => $data['payable_type'] ?? null,
            'payable_id'      => $data['payable_id'] ?? null,
            'subscription_id' => $data['subscription_id'] ?? null,
            'description'     => $data['description'],
            'status'          => 'pending',
            'callback_url'    => $callbackUrl,
            'mobile'          => $data['mobile'] ?? null,
        ]);

        $totalToman = (int)$payment->amount + (int)$payment->tax_amount + (int)$payment->fee_amount;

        $result = match ($this->gateway) {
            'zarinpal' => $this->zarinpalRequest($payment, $totalToman * 10, $callbackUrl),
            'zibal'    => $this->zibalRequest($payment, $totalToman, $callbackUrl),
            'payping'  => $this->paypingRequest($payment, $totalToman, $callbackUrl),
            default    => ['success' => false, 'message' => 'درگاه نامعتبر'],
        };

        if (!$result['success']) {
            $payment->update(['status' => 'failed', 'gateway_response' => $result]);
        }

        return array_merge($result, ['payment' => $payment]);
    }

    /**
     * Verify callback from gateway. Auto-detects gateway from stored Payment record.
     */
    public function verify(Request $request): array
    {
        // Try to find the pending payment to determine gateway
        $payment = $this->findPendingPayment($request);

        if ($payment) {
            // Re-init with the payment's gateway
            $this->gateway = $payment->gateway;
            $this->config  = $this->loadConfig($this->gateway);
        }

        $result = match ($this->gateway) {
            'zarinpal' => $this->zarinpalVerify($request),
            'zibal'    => $this->zibalVerify($request),
            'payping'  => $this->paypingVerify($request),
            default    => ['success' => false, 'message' => 'درگاه نامعتبر'],
        };

        return $result;
    }

    /**
     * Try to identify the pending Payment from callback params.
     */
    protected function findPendingPayment(Request $request): ?Payment
    {
        // ZarinPal
        if ($authority = $request->get('Authority')) {
            $p = Payment::where('authority', $authority)->where('status', 'pending')->first();
            if ($p) return $p;
        }
        // Zibal
        if ($trackId = $request->get('trackId')) {
            $p = Payment::where('authority', (string)$trackId)->where('status', 'pending')->first();
            if ($p) return $p;
        }
        // PayPing
        if ($code = $request->get('code')) {
            $p = Payment::where('authority', $code)->where('status', 'pending')->first();
            if ($p) return $p;
        }
        if ($clientRefId = $request->get('clientrefid')) {
            $p = Payment::where('id', $clientRefId)->where('status', 'pending')->first();
            if ($p) return $p;
        }
        return null;
    }

    // ─────────────────────────────────────────────────────────────
    // ZarinPal
    // ─────────────────────────────────────────────────────────────

    protected function zarinpalRequest(Payment $payment, int $amountRials, string $callbackUrl): array
    {
        $sandbox  = $this->config['sandbox'] ?? false;
        $endpoint = $sandbox
            ? 'https://sandbox.zarinpal.com/pg/v4/payment/request.json'
            : 'https://payment.zarinpal.com/pg/v4/payment/request.json';

        try {
            $response = Http::timeout(15)->post($endpoint, [
                'merchant_id'  => $this->config['merchant'],
                'amount'       => $amountRials,
                'description'  => $payment->description,
                'callback_url' => $callbackUrl,
                'metadata'     => ['mobile' => $payment->mobile, 'order_id' => (string) $payment->id],
            ]);

            $data = $response->json();
            Log::info('ZarinPal request', $data);

            if (($data['data']['code'] ?? -1) === 100) {
                $authority = $data['data']['authority'];
                $payment->update(['authority' => $authority, 'gateway_response' => $data]);
                $url = $sandbox
                    ? "https://sandbox.zarinpal.com/pg/StartPay/{$authority}"
                    : "https://www.zarinpal.com/pg/StartPay/{$authority}";
                return ['success' => true, 'url' => $url];
            }
            return ['success' => false, 'message' => 'خطای زرین‌پال: ' . ($data['errors']['message'] ?? 'نامشخص')];
        } catch (\Exception $e) {
            Log::error('ZarinPal request error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'خطا در اتصال به زرین‌پال: ' . $e->getMessage()];
        }
    }

    protected function zarinpalVerify(Request $request): array
    {
        $authority = $request->get('Authority');
        $status    = $request->get('Status');
        $payment   = Payment::where('authority', $authority)->where('status', 'pending')->first();

        if (!$payment) return ['success' => false, 'message' => 'تراکنش یافت نشد.'];
        if ($status !== 'OK') {
            $payment->update(['status' => 'failed']);
            return ['success' => false, 'payment' => $payment, 'message' => 'پرداخت لغو یا ناموفق بود.'];
        }

        $sandbox  = $this->config['sandbox'] ?? false;
        $endpoint = $sandbox
            ? 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json'
            : 'https://payment.zarinpal.com/pg/v4/payment/verify.json';

        $amountRials = ((int)$payment->amount + (int)$payment->tax_amount + (int)$payment->fee_amount) * 10;

        try {
            $response = Http::timeout(15)->post($endpoint, [
                'merchant_id' => $this->config['merchant'],
                'amount'      => $amountRials,
                'authority'   => $authority,
            ]);
            $data  = $response->json();
            $code  = $data['data']['code'] ?? -1;
            $refId = (string) ($data['data']['ref_id'] ?? '');
            Log::info('ZarinPal verify', $data);

            if (in_array($code, [100, 101])) {
                $payment->update(['status' => 'paid', 'ref_id' => $refId, 'gateway_response' => $data]);
                return ['success' => true, 'payment' => $payment, 'ref_id' => $refId];
            }
            $payment->update(['status' => 'failed', 'gateway_response' => $data]);
            return ['success' => false, 'payment' => $payment, 'message' => 'تأیید ناموفق (کد: ' . $code . ')'];
        } catch (\Exception $e) {
            Log::error('ZarinPal verify error: ' . $e->getMessage());
            return ['success' => false, 'payment' => $payment, 'message' => $e->getMessage()];
        }
    }

    // ─────────────────────────────────────────────────────────────
    // Zibal
    // ─────────────────────────────────────────────────────────────

    protected function zibalRequest(Payment $payment, int $amountToman, string $callbackUrl): array
    {
        try {
            $response = Http::timeout(15)->post('https://gateway.zibal.ir/v1/request', [
                'merchant'    => $this->config['merchant'],
                'amount'      => $amountToman * 10,
                'callbackUrl' => $callbackUrl,
                'description' => $payment->description,
                'orderId'     => (string) $payment->id,
                'mobile'      => $payment->mobile,
            ]);
            $data = $response->json();
            Log::info('Zibal request', $data);
            if (($data['result'] ?? -1) === 100) {
                $trackId = $data['trackId'];
                $payment->update(['authority' => (string)$trackId, 'gateway_response' => $data]);
                return ['success' => true, 'url' => "https://gateway.zibal.ir/start/{$trackId}"];
            }
            return ['success' => false, 'message' => 'خطای زیبال: ' . ($data['message'] ?? 'نامشخص')];
        } catch (\Exception $e) {
            Log::error('Zibal request error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    protected function zibalVerify(Request $request): array
    {
        $trackId = $request->get('trackId') ?? $request->get('authority');
        $success = $request->get('success');
        $payment = Payment::where('authority', (string)$trackId)->where('status', 'pending')->first();

        if (!$payment) return ['success' => false, 'message' => 'تراکنش یافت نشد.'];
        if ((int)$success !== 1) {
            $payment->update(['status' => 'failed']);
            return ['success' => false, 'payment' => $payment, 'message' => 'پرداخت لغو شد.'];
        }

        try {
            $response = Http::timeout(15)->post('https://gateway.zibal.ir/v1/verify', [
                'merchant' => $this->config['merchant'],
                'trackId'  => (int)$trackId,
            ]);
            $data  = $response->json();
            Log::info('Zibal verify', $data);
            if (($data['result'] ?? -1) === 100) {
                $refId = (string)($data['refNumber'] ?? $trackId);
                $payment->update(['status' => 'paid', 'ref_id' => $refId, 'gateway_response' => $data]);
                return ['success' => true, 'payment' => $payment, 'ref_id' => $refId];
            }
            $payment->update(['status' => 'failed', 'gateway_response' => $data]);
            return ['success' => false, 'payment' => $payment, 'message' => 'تأیید زیبال ناموفق (کد: ' . ($data['result'] ?? '?') . ')'];
        } catch (\Exception $e) {
            Log::error('Zibal verify error: ' . $e->getMessage());
            return ['success' => false, 'payment' => $payment, 'message' => $e->getMessage()];
        }
    }

    // ─────────────────────────────────────────────────────────────
    // PayPing
    // ─────────────────────────────────────────────────────────────

    protected function paypingRequest(Payment $payment, int $amountToman, string $callbackUrl): array
    {
        try {
            $response = Http::timeout(15)
                ->withToken($this->config['token'])
                ->post('https://api.payping.ir/v2/pay', [
                    'amount'        => $amountToman,
                    'returnUrl'     => $callbackUrl,
                    'description'   => $payment->description,
                    'payerIdentity' => $payment->mobile,
                    'clientRefId'   => (string) $payment->id,
                ]);
            $data = $response->json();
            Log::info('PayPing request', $data);
            if (!empty($data['code'])) {
                $code = $data['code'];
                $payment->update(['authority' => $code, 'gateway_response' => $data]);
                return ['success' => true, 'url' => "https://api.payping.ir/v2/pay/gotoipg/{$code}"];
            }
            return ['success' => false, 'message' => 'خطای پی‌پینگ: ' . json_encode($data, JSON_UNESCAPED_UNICODE)];
        } catch (\Exception $e) {
            Log::error('PayPing request error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    protected function paypingVerify(Request $request): array
    {
        $code        = $request->get('code') ?? $request->get('authority');
        $refId       = $request->get('refid');
        $clientRefId = $request->get('clientrefid');

        $payment = Payment::where('authority', $code)->where('status', 'pending')->first()
            ?? ($clientRefId ? Payment::where('id', $clientRefId)->where('status', 'pending')->first() : null);

        if (!$payment) return ['success' => false, 'message' => 'تراکنش یافت نشد.'];
        if (empty($refId)) {
            $payment->update(['status' => 'failed']);
            return ['success' => false, 'payment' => $payment, 'message' => 'پرداخت لغو شد.'];
        }

        try {
            $response = Http::timeout(15)
                ->withToken($this->config['token'])
                ->post('https://api.payping.ir/v2/pay/verify', [
                    'amount' => (int)($payment->amount + $payment->tax_amount + $payment->fee_amount),
                    'refId'  => $refId,
                ]);
            $data = $response->json();
            Log::info('PayPing verify', $data);
            if ($response->successful() && !empty($data['amount'])) {
                $payment->update(['status' => 'paid', 'ref_id' => $refId, 'gateway_response' => $data]);
                return ['success' => true, 'payment' => $payment, 'ref_id' => $refId];
            }
            $payment->update(['status' => 'failed', 'gateway_response' => $data]);
            return ['success' => false, 'payment' => $payment, 'message' => 'تأیید پی‌پینگ ناموفق'];
        } catch (\Exception $e) {
            Log::error('PayPing verify error: ' . $e->getMessage());
            return ['success' => false, 'payment' => $payment, 'message' => $e->getMessage()];
        }
    }
}
