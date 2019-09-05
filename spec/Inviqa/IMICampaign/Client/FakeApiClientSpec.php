<?php

namespace spec\Inviqa\IMICampaign\Client;

use Inviqa\IMICampaign\Configuration;
use PhpSpec\ObjectBehavior;
use TestService\TestRequestFactory;
use TestService\TestResponseFactory;
use Webmozart\Assert\Assert;

class FakeApiClientSpec extends ObjectBehavior
{
    function let(Configuration $configuration)
    {
        $this->beConstructedWith($configuration);
    }

    function it_makes_use_of_extra_configuration_to_return_a_success_predetermined_result(Configuration $configuration)
    {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $transactionId = 'evt_123';

        $eventPayload = TestRequestFactory::buildEventJsonPayload($eventId, $eventKey);
        $responseJson = TestResponseFactory::buildSuccessResponseJson($transactionId);

        $configuration->getExtraConfig()->willReturn([
            'testResults'        => [
                'success' => [
                    md5($eventId . $eventKey) => $transactionId,
                ],
                'failure' => [],
            ],
            'afterSendCallbacks' => [],
        ]);

        $this->sendEvent($eventPayload)->shouldBe($responseJson);
    }

    function it_makes_use_of_extra_configuration_to_return_a_failure_predetermined_result(Configuration $configuration)
    {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $apiResponseCode = 1001;
        $errorDescription = 'Invalid input JSON';

        $eventPayload = TestRequestFactory::buildEventJsonPayload($eventId, $eventKey);
        $responseJson = TestResponseFactory::buildFailureResponseJson($apiResponseCode, $errorDescription);

        $configuration->getExtraConfig()->willReturn([
            'testResults'        => [
                'success' => [],
                'failure' => [
                    md5($eventId . $eventKey) => [
                        'code'        => $apiResponseCode,
                        'description' => $errorDescription,
                    ],
                ],
            ],
            'afterSendCallbacks' => [],
        ]);

        $this->sendEvent($eventPayload)->shouldBe($responseJson);
    }

    function it_calls_after_send_callbacks_before_returning(Configuration $configuration)
    {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $transactionId = 'evt_123';

        $eventPayload = TestRequestFactory::buildEventJsonPayload($eventId, $eventKey);

        $afterSendCallbackClosure = static function ($calledJsonPayload) use ($eventPayload, &$callBackCalled) {
            Assert::eq($calledJsonPayload, $eventPayload);
            $callBackCalled = true;
        };

        $configuration->getExtraConfig()->willReturn([
            'testResults'        => [
                'success' => [
                    md5($eventId . $eventKey) => $transactionId,
                ],
                'failure' => [],
            ],
            'afterSendCallbacks' => [
                $afterSendCallbackClosure,
            ],
        ]);

        $this->sendEvent($eventPayload);

        Assert::true($callBackCalled);
    }
}
