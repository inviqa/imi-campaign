<?php

namespace Inviqa\IMICampaign\Response;

use Inviqa\IMICampaign\Exception\UnknownResponseException;
use function json_decode;

class ResponseParser
{
    public const UNKNOWN_RESPONSE_MESSAGE = 'Unable to build a result from the response';

    public function extractEventResultFrom(string $responseBody): EventResult
    {
        $decodedResponse = json_decode($responseBody, true);

        if (array_key_exists('transaction-id', $decodedResponse)) {
            return EventResult::successFromTransactionId($decodedResponse['transaction-id']);
        }

        if (array_key_exists('code', $decodedResponse) && array_key_exists('description', $decodedResponse)) {
            return EventResult::failureFromApiResponseCodeAndDescription(
                $decodedResponse['code'],
                $decodedResponse['description']
            );
        }

        throw new UnknownResponseException(self::UNKNOWN_RESPONSE_MESSAGE);
    }
}
