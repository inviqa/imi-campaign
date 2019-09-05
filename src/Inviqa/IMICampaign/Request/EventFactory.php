<?php

namespace Inviqa\IMICampaign\Request;

use Inviqa\IMICampaign\Request\Event\Event;
use Inviqa\IMICampaign\Request\Event\EventId;
use Inviqa\IMICampaign\Request\Event\EventKey;
use Inviqa\IMICampaign\Request\Event\EventParameter;
use Inviqa\IMICampaign\Request\Event\EventParameters;

class EventFactory
{
    public function buildFrom(string $eventId, string $eventKey, array $eventParameters): Event
    {
        return new Event(
            new EventId($eventId),
            new EventKey($eventKey),
            new EventParameters(array_map(static function ($value, $key) {
                return new EventParameter($key, $value);
            }, $eventParameters, array_keys($eventParameters)))
        );
    }
}
