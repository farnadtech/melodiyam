<?php

namespace App\Services;

use App\Models\SmsProvider;
use App\Services\SmsDrivers\MelipayamakDriver;
use App\Services\SmsDrivers\SmsIrDriver;
use Exception;

class SmsService
{
    protected $driver;

    public function __construct()
    {
        $provider = SmsProvider::where('is_active', true)->first();
        if ($provider) {
            $this->driver = $this->resolveDriver($provider);
        }
    }

    protected function resolveDriver(SmsProvider $provider)
    {
        return match ($provider->driver) {
            'melipayamak' => new MelipayamakDriver($provider->credentials),
            'smsir' => new SmsIrDriver($provider->credentials),
            default => throw new Exception("Unsupported SMS driver: {$provider->driver}"),
        };
    }

    public function sendText(string $phone, string $text)
    {
        if (!$this->driver) return ['success' => false, 'message' => 'No active SMS provider.'];
        return $this->driver->sendText($phone, $text);
    }

    public function sendByPattern(string $phone, string $patternId, array $params = [])
    {
        if (!$this->driver) return ['success' => false, 'message' => 'No active SMS provider.'];
        return $this->driver->sendByPattern($phone, $patternId, $params);
    }
}
