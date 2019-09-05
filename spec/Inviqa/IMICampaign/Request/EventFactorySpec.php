<?php

namespace spec\Inviqa\IMICampaign\Request;

use PhpSpec\ObjectBehavior;
use TestService\TestRequestFactory;

class EventFactorySpec extends ObjectBehavior
{
    function it_converts_the_given_parameters_into_an_event_value_object()
    {
        $eventId = 'evt_123';
        $eventKey = 'user@example.com';
        $eventParameters = ['first_name' => 'John'];

        $eventValueObject = TestRequestFactory::buildEventValueObject($eventId, $eventKey, $eventParameters);

        $this->buildFrom($eventId, $eventKey, $eventParameters)->shouldBeLike($eventValueObject);
    }
}
