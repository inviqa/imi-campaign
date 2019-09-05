<?php

namespace Inviqa\IMICampaign\Response;

class EventResult
{
    public const SUCCESS_API_RESPONSE_CODE = 200;

    /**
     * @var bool
     */
    private $success = false;

    /**
     * @var bool
     */
    private $failure = false;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var int
     */
    private $apiResponseCode;

    /**
     * @var string|null
     */
    private $description;

    private function __construct()
    {
    }

    public static function successFromTransactionId(string $transactionId): EventResult
    {
        $eventResult = new self();

        $eventResult->success = true;
        $eventResult->transactionId = $transactionId;
        $eventResult->apiResponseCode = self::SUCCESS_API_RESPONSE_CODE;

        return $eventResult;
    }

    public static function failureFromApiResponseCodeAndDescription(int $apiResponseCode, string $description): EventResult
    {
        $eventResult = new self();

        $eventResult->failure = true;
        $eventResult->apiResponseCode = $apiResponseCode;
        $eventResult->description = $description;

        return $eventResult;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function isFailure(): bool
    {
        return $this->failure;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function getApiResponseCode(): int
    {
        return $this->apiResponseCode;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
