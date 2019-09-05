<?php

namespace Inviqa\IMICampaign\Request\Event;

use Inviqa\IMICampaign\Exception\InvalidRequestParameterException;
use JsonSerializable;

class EventId implements JsonSerializable
{
    private $eventId;

    public function __construct(string $eventId)
    {
        if ('' == $eventId) {
            throw new InvalidRequestParameterException(sprintf(
                "Invalid event-id request parameter. Expected a non-empty value. Got '%s'.",
                $eventId
            ));
        }

        $this->eventId = $eventId;
    }

    public function jsonSerialize()
    {
        return $this->eventId;
    }
}
