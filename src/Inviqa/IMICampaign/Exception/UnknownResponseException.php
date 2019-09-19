<?php

namespace Inviqa\IMICampaign\Exception;

class UnknownResponseException extends IMICampaignException
{
    public const UNKNOWN_RESPONSE_MESSAGE = 'Unknown response returned from the API: "%s"';

    public static function withResponseBody(?string $responseBody): UnknownResponseException
    {
        $exception = new static(sprintf(self::UNKNOWN_RESPONSE_MESSAGE, $responseBody));
        return $exception;
    }
}
