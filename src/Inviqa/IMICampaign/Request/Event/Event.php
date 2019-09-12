<?php

namespace Inviqa\IMICampaign\Request\Event;

use JsonSerializable;
use function json_encode;

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

    public function getEventId(): EventId
    {
        return $this->eventId;
    }

    public function getEventKey(): EventKey
    {
        return $this->eventKey;
    }

    public function toJson(): string
    {
        return json_encode($this);
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
