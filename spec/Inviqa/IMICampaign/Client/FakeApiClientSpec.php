<?php

namespace spec\Inviqa\IMICampaign\Client;

use Inviqa\IMICampaign\Configuration;
use Inviqa\IMICampaign\Exception\IMICampaignException;
use Inviqa\IMICampaign\Request\Event\Event;
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

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey);
        $responseJson = TestResponseFactory::buildSuccessResponseJson($transactionId);

        $configuration->getExtraConfig()->willReturn([
            'testResults'        => [
                'success'   => [
                    md5($eventId . $eventKey) => $transactionId,
                ],
                'failure'   => [],
                'exception' => [],
            ],
            'afterSendCallbacks' => [],
        ]);

        $this->sendEvent($eventValueObject)->shouldBe($responseJson);
    }

    function it_makes_use_of_extra_configuration_to_return_a_failure_predetermined_result(Configuration $configuration)
    {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $apiResponseCode = 1001;
        $errorDescription = 'Invalid input JSON';

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey);
        $responseJson = TestResponseFactory::buildFailureResponseJson($apiResponseCode, $errorDescription);

        $configuration->getExtraConfig()->willReturn([
            'testResults'        => [
                'success'   => [],
                'failure'   => [
                    md5($eventId . $eventKey) => [
                        'code'        => $apiResponseCode,
                        'description' => $errorDescription,
                    ],
                ],
                'exception' => [],
            ],
            'afterSendCallbacks' => [],
        ]);

        $this->sendEvent($eventValueObject)->shouldBe($responseJson);
    }

    function it_makes_use_of_extra_configuration_to_throw_an_exception(Configuration $configuration)
    {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $exceptionMessage = 'Exceptional!';

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey);
        $expectedException = new IMICampaignException($exceptionMessage);

        $configuration->getExtraConfig()->willReturn([
            'testResults'        => [
                'success'   => [],
                'failure'   => [],
                'exception' => [
                    md5($eventId . $eventKey) => [
                        'message' => $exceptionMessage,
                    ],
                ],
            ],
            'afterSendCallbacks' => [],
        ]);

        $this
            ->shouldThrow($expectedException)
            ->during('sendEvent', [$eventValueObject]);
    }

    function it_calls_after_send_callbacks_before_returning(Configuration $configuration)
    {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $transactionId = 'evt_123';

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey);

        $afterSendCallbackClosure = static function (Event $event) use ($eventValueObject, &$callBackCalled) {
            Assert::eq($event, $eventValueObject);
            $callBackCalled = true;
        };

        $configuration->getExtraConfig()->willReturn([
            'testResults'        => [
                'success'   => [
                    md5($eventId . $eventKey) => $transactionId,
                ],
                'failure'   => [],
                'exception' => [],
            ],
            'afterSendCallbacks' => [
                $afterSendCallbackClosure,
            ],
        ]);

        $this->sendEvent($eventValueObject);

        Assert::true($callBackCalled);
    }
}
