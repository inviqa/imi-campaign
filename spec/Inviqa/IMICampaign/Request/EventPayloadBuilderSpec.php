<?php

namespace spec\Inviqa\IMICampaign\Request;

use Inviqa\IMICampaign\Request\EventFactory;
use Inviqa\IMICampaign\Request\JsonConverter;
use PhpSpec\ObjectBehavior;
use TestService\TestRequestFactory;

class EventPayloadBuilderSpec extends ObjectBehavior
{
    function let(
        EventFactory $eventFactory,
        JsonConverter $jsonConverter
    ) {
        $this->beConstructedWith($eventFactory, $jsonConverter);
    }

    function it_converts_the_given_arguments_into_a_json_payload(
        EventFactory $eventFactory,
        JsonConverter $jsonConverter
    ) {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $eventParameters = ['first_name' => 'John'];

        $expectedPayload = TestRequestFactory::buildEventJsonPayload($eventId, $eventKey, $eventParameters);

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey, $eventParameters);

        $eventFactory->buildFrom($eventId, $eventKey, $eventParameters)->willReturn($eventValueObject);
        $jsonConverter->convert($eventValueObject)->willReturn($expectedPayload);

        $this->buildFrom($eventId, $eventKey, $eventParameters)->shouldBe($expectedPayload);
    }
}
