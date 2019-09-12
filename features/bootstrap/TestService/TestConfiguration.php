<?php

namespace TestService;

use Inviqa\IMICampaign\Configuration;

class TestConfiguration implements Configuration
{
    private $apiToken = 'sampleApiToken';

    private $domain = 'https://email.example.com';

    private $extraConfig = [
        'testResults'        => [
            'success' => [],
            'failure' => [],
        ],
        'afterSendCallbacks' => [],
    ];

    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function isTestMode(): bool
    {
        return true;
    }

    public function getExtraConfig(): array
    {
        return $this->extraConfig;
    }

    public function addSuccessEvent(string $eventId, string $eventKey, string $transactionId)
    {
        $this->extraConfig['testResults']['success'][md5($eventId . $eventKey)] = $transactionId;
    }

    public function addFailureEvent(string $eventId, string $eventKey, string $apiResponseCode, string $errorDescription)
    {
        $this->extraConfig['testResults']['failure'][md5($eventId . $eventKey)] = [
            'code'        => $apiResponseCode,
            'description' => $errorDescription,
        ];
    }
}
