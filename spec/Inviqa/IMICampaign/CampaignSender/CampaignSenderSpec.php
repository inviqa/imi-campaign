<?php

namespace spec\Inviqa\IMICampaign\CampaignSender;

use Inviqa\IMICampaign\Client\ApiClient;
use Inviqa\IMICampaign\Request\EventFactory;
use Inviqa\IMICampaign\Response\EventResult;
use Inviqa\IMICampaign\Response\ResponseParser;
use PhpSpec\ObjectBehavior;
use TestService\TestRequestFactory;
use TestService\TestResponseFactory;

class CampaignSenderSpec extends ObjectBehavior
{
    function let(
        ApiClient $apiClient,
        EventFactory $eventFactory,
        ResponseParser $responseParser
    ) {
        $this->beConstructedWith($apiClient, $eventFactory, $responseParser);
    }

    function it_sends_an_event_api_request_and_returns_an_event_result(
        ApiClient $apiClient,
        EventFactory $eventFactory,
        ResponseParser $responseParser
    ) {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $eventParameters = [
            'first_name' => 'John',
        ];

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey, $eventParameters);

        $responseJson = TestResponseFactory::buildSuccessResponseJson('event_123');

        $eventResult = EventResult::successFromTransactionId('event_123');

        $eventFactory->buildFrom($eventId, $eventKey, $eventParameters)->willReturn($eventValueObject);
        $apiClient->sendEvent($eventValueObject)->willReturn($responseJson);
        $responseParser->extractEventResultFrom($responseJson)->willReturn($eventResult);

        $this->sendEvent($eventId, $eventKey, $eventParameters)->shouldBe($eventResult);
    }
}
