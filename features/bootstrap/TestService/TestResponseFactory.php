<?php

namespace TestService;

class TestResponseFactory
{
    public static function buildSuccessResponseJson(string $eventId = 'event_123')
    {
        return json_encode([
            'transaction-id' => $eventId,
        ]);
    }

    public static function buildFailureResponseJson(int $apiResponseCode, string $errorDescription)
    {
        return json_encode([
            'code'        => $apiResponseCode,
            'description' => $errorDescription,
        ]);
    }
}
