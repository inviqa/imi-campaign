<?php

namespace Inviqa\IMICampaign\Request\Event;

use JsonSerializable;

class EventParameters implements JsonSerializable
{
    /**
     * @var EventParameter[]
     */
    private $eventParameters = [];

    public function __construct(array $eventParameters)
    {
        foreach ($eventParameters as $eventParameter) {
            $this->addParameter($eventParameter);
        }
    }

    public function addParameter(EventParameter $eventParameter)
    {
        $this->eventParameters[] = $eventParameter;
    }

    public function jsonSerialize()
    {
        $eventParameters = [];

        foreach ($this->eventParameters as $eventParameter) {
            $eventParameters[$eventParameter->getKey()] = $eventParameter->getValue();
        }

        return $eventParameters;
    }
}
