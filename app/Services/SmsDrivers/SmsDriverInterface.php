<?php

namespace App\Services\SmsDrivers;

interface SmsDriverInterface
{
    public function sendText(string $phone, string $text): array;
    public function sendByPattern(string $phone, string $patternId, array $params = []): array;
}
