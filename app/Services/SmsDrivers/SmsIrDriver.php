<?php

namespace App\Services\SmsDrivers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsIrDriver implements SmsDriverInterface
{
    protected array $config;
    const BASE_URL = 'https://api.sms.ir/v1';

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function sendText(string $phone, string $text): array
    {
        try {
            $response = Http::withHeaders([
                'X-API-KEY' => $this->config['api_key'] ?? '',
                'ACCEPT' => 'application/json',
            ])->post(self::BASE_URL . '/send/bulk', [
                'lineNumber' => $this->config['line_number'] ?? '',
                'messageText' => $text,
                'mobiles' => [$phone],
            ]);

            $data = $response->json();
            return [
                'success' => ($data['status'] ?? 0) == 1,
                'message' => $data['message'] ?? 'Unknown error',
                'response' => $data
            ];
        } catch (\Exception $e) {
            Log::error("Sms.ir error: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function sendByPattern(string $phone, string $patternId, array $params = []): array
    {
        try {
            $parameters = [];
            foreach ($params as $name => $value) {
                $parameters[] = ['name' => (string)$name, 'value' => (string)$value];
            }

            $response = Http::withHeaders([
                'X-API-KEY' => $this->config['api_key'] ?? '',
                'ACCEPT' => 'application/json',
            ])->post(self::BASE_URL . '/send/verify', [
                'mobile' => $phone,
                'templateId' => (int)$patternId,
                'parameters' => $parameters,
            ]);

            $data = $response->json();
            return [
                'success' => ($data['status'] ?? 0) == 1,
                'message' => $data['message'] ?? 'Unknown error',
                'response' => $data
            ];
        } catch (\Exception $e) {
            Log::error("Sms.ir pattern error: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
