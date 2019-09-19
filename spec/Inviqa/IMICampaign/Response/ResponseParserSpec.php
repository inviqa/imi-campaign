<?php

namespace spec\Inviqa\IMICampaign\Response;

use Inviqa\IMICampaign\Exception\UnknownResponseException;
use Inviqa\IMICampaign\Response\EventResult;
use Inviqa\IMICampaign\Response\ResponseParser;
use PhpSpec\ObjectBehavior;
use TestService\TestResponseFactory;

class ResponseParserSpec extends ObjectBehavior
{
    function it_receives_successful_response_json_and_returns_a_successful_result()
    {
        $responseBody = TestResponseFactory::buildSuccessResponseJson('evt_123');
        $eventResult = EventResult::successFromTransactionId('evt_123');

        $this->extractEventResultFrom($responseBody)->shouldBeLike($eventResult);
    }

    function it_receives_failed_response_json_and_returns_a_failure_result()
    {
        $responseBody = TestResponseFactory::buildFailureResponseJson(1001, 'Invalid input JSON');
        $eventResult = EventResult::failureFromApiResponseCodeAndDescription(1001, 'Invalid input JSON');

        $this->extractEventResultFrom($responseBody)->shouldBeLike($eventResult);
    }

    function it_throws_an_exception_if_unable_to_identify_the_response_when_it_is_an_array()
    {
        $responseBody = '{"bad-response": "yes"}';

        $this
            ->shouldThrow(UnknownResponseException::withResponseBody($responseBody))
            ->duringExtractEventResultFrom($responseBody)
        ;
    }

    function it_throws_an_exception_if_unable_to_identify_the_response_when_it_cannot_be_json_decoded()
    {
        $responseBody = 'Bad Response!';

        $this
            ->shouldThrow(UnknownResponseException::withResponseBody($responseBody))
            ->duringExtractEventResultFrom($responseBody)
        ;
    }
}
