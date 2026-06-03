<?php

namespace App\Services\SmsDrivers;

use Illuminate\Support\Facades\Log;

class MelipayamakDriver implements SmsDriverInterface
{
    protected array $config;
    const SOAP_WSDL = 'http://api.payamak-panel.com/post/Send.asmx?wsdl';

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function sendText(string $phone, string $text): array
    {
        try {
            $response = \Illuminate\Support\Facades\Http::post('https://rest.payamak-panel.com/api/SendSMS/SendSMS', [
                'username' => $this->config['username'] ?? '',
                'password' => $this->config['password'] ?? '',
                'to' => $phone,
                'from' => $this->config['from'] ?? '',
                'text' => $text,
                'isFlash' => false,
            ]);

            $result = $response->json();
            $status = (int)($result['RetStatus'] ?? -1);
            $value = (string)($result['Value'] ?? '');
            
            // In REST API, RetStatus 1 and Value > 100 usually means success (RecId)
            $success = ($status === 1 && strlen($value) > 5);
            
            return [
                'success' => $success,
                'message' => $success ? 'ارسال موفقیت‌آمیز بود (کد پیگیری: ' . $value . ')' : $this->getRestError($status, $value),
                'response' => $result
            ];
        } catch (\Exception $e) {
            Log::error("Melipayamak REST error: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    protected function getRestError(int $status, string $value): string
    {
        if ($status === 1) return "خطا در پردازش درگاه (مقدار: $value)";
        
        return match ($status) {
            0 => 'نام کاربری یا رمز عبور اشتباه است.',
            2 => 'موجودی حساب کافی نیست.',
            3 => 'حساب کاربری غیرفعال است.',
            4 => 'شماره گیرنده نامعتبر است.',
            5 => 'شماره فرستنده نامعتبر است.',
            6 => 'حساب کاربری فعال نشده است یا مدارک تایید نشده است.',
            default => "خطای درگاه (کد: $status, مقدار: $value)",
        };
    }

    public function sendByPattern(string $phone, string $patternId, array $params = []): array
    {
        try {
            // Use semicolon (;) as separator for multiple variables in MeliPayamak REST pattern
            // The order of values should match {0}, {1}, {2}, ... in the panel
            $text = implode(';', array_values($params));

            $response = \Illuminate\Support\Facades\Http::post('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber', [
                'username' => $this->config['username'] ?? '',
                'password' => $this->config['password'] ?? '',
                'to' => $phone,
                'text' => $text,
                'bodyId' => (int)$patternId,
            ]);

            $result = $response->json();
            $status = (int)($result['RetStatus'] ?? -1);
            $value = (string)($result['Value'] ?? '');
            
            // Success if status is 1 and Value is a long RecId (usually > 5 digits)
            $success = ($status === 1 && strlen($value) > 5);
            
            return [
                'success' => $success,
                'message' => $success ? 'ارسال پترن موفقیت‌آمیز بود (کد پیگیری: ' . $value . ')' : $this->getRestError($status, $value),
                'response' => $result
            ];
        } catch (\Exception $e) {
            Log::error("Melipayamak REST pattern error: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
