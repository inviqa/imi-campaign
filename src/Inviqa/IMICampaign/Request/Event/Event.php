<?php

namespace Inviqa\IMICampaign\Request\Event;

use JsonSerializable;

class Event implements JsonSerializable
{
    private $eventId;
    private $eventKey;
    private $eventParameters;

    public function __construct(EventId $eventId, EventKey $eventKey, EventParameters $eventParameters)
    {
        $this->eventId = $eventId;
        $this->eventKey = $eventKey;
        $this->eventParameters = $eventParameters;
    }

    public function jsonSerialize()
    {
        return [
            'event-id'     => $this->eventId,
            'event-key'    => $this->eventKey,
            'event-params' => $this->eventParameters,
        ];
    }
}
