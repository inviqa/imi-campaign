<?php

namespace TestService;

use Inviqa\IMICampaign\Request\Event\Event;
use Inviqa\IMICampaign\Request\Event\EventId;
use Inviqa\IMICampaign\Request\Event\EventKey;
use Inviqa\IMICampaign\Request\Event\EventParameter;
use Inviqa\IMICampaign\Request\Event\EventParameters;

class TestRequestFactory
{
    public static function buildEventJsonPayload($eventId = 'evt_123', $eventKey = 'user@example.com', $eventParameters = ['first_name' => 'John']): string
    {
        return json_encode([
            'event-id'     => $eventId,
            'event-key'    => $eventKey,
            'event-params' => $eventParameters,
        ]);
    }

    public static function buildEventValueObject($eventId = 'evt_123', $eventKey = 'user@example.com', $eventParameters = ['first_name' => 'John'])
    {
        return new Event(
            new EventId($eventId),
            new EventKey($eventKey),
            self::buildEventParameters($eventParameters)
        );
    }

    private static function buildEventParameters(array $eventParameters): EventParameters
    {
        $eventParameterObjects = [];

        foreach ($eventParameters as $key => $value) {
            $eventParameterObjects[] = new EventParameter($key, $value);
        }

        return new EventParameters($eventParameterObjects);
    }
}
