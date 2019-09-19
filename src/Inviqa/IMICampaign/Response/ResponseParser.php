<?php

namespace Inviqa\IMICampaign\Response;

use Inviqa\IMICampaign\Exception\UnknownResponseException;
use function json_decode;

class ResponseParser
{
    public function extractEventResultFrom(string $responseBody): EventResult
    {
        $decodedResponse = json_decode($responseBody, true);

        if (! is_array($decodedResponse)) {
            throw UnknownResponseException::withResponseBody($responseBody);
        }

        if (array_key_exists('transaction-id', $decodedResponse)) {
            return EventResult::successFromTransactionId($decodedResponse['transaction-id']);
        }

        if (array_key_exists('code', $decodedResponse) && array_key_exists('description', $decodedResponse)) {
            return EventResult::failureFromApiResponseCodeAndDescription(
                $decodedResponse['code'],
                $decodedResponse['description']
            );
        }

        throw UnknownResponseException::withResponseBody($responseBody);
    }
}
