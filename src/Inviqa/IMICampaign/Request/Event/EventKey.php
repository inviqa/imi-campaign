<?php

namespace Inviqa\IMICampaign\Request\Event;

use Inviqa\IMICampaign\Exception\InvalidRequestParameterException;
use JsonSerializable;

class EventKey implements JsonSerializable
{
    private $eventKey;

    public function __construct(string $eventKey)
    {
        if ('' == $eventKey) {
            throw new InvalidRequestParameterException(sprintf(
                "Invalid event-key request parameter. Expected a non-empty value. Got '%s'.",
                $eventKey
            ));
        }

        $this->eventKey = $eventKey;
    }

    public function __toString()
    {
        return $this->eventKey;
    }

    public function jsonSerialize()
    {
        return $this->eventKey;
    }
}
