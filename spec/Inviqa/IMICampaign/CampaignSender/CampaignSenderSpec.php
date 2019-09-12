<?php

namespace spec\Inviqa\IMICampaign\CampaignSender;

use GuzzleHttp\Exception\TransferException;
use Inviqa\IMICampaign\Client\ApiClient;
use Inviqa\IMICampaign\Exception\IMICampaignException;
use Inviqa\IMICampaign\Request\EventFactory;
use Inviqa\IMICampaign\Response\EventResult;
use Inviqa\IMICampaign\Response\ResponseParser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
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

    function it_transforms_thrown_exceptions_into_imi_campaign_exceptions
    (
        ApiClient $apiClient,
        EventFactory $eventFactory,
        ResponseParser $responseParser
    ) {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $eventParameters = [
            'first_name' => 'John',
        ];

        $exceptionMessage = 'Exceptional!';
        $exceptionCode = '666';

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey, $eventParameters);
        $transferException = new TransferException($exceptionMessage, $exceptionCode);
        $expectedException = new IMICampaignException($exceptionMessage, $exceptionCode, $transferException);

        $eventFactory->buildFrom($eventId, $eventKey, $eventParameters)->willReturn($eventValueObject);
        $apiClient->sendEvent($eventValueObject)->willThrow($transferException);

        $responseParser->extractEventResultFrom(Argument::any())->shouldNotBeCalled();

        $this->shouldThrow($expectedException)->during('sendEvent', [$eventId, $eventKey, $eventParameters]);
    }
}
