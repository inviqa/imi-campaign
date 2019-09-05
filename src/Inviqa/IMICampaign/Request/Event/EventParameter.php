<?php

namespace Inviqa\IMICampaign\Request\Event;

use Inviqa\IMICampaign\Exception\InvalidRequestParameterException;

class EventParameter
{
    private $key;
    private $value;

    public function __construct(string $key, ?string $value)
    {
        if ('' == $key) {
            throw new InvalidRequestParameterException(sprintf(
                "Invalid key for event-param entry. Expected a non-empty value. Got '%s'.",
                $key
            ));
        }

        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
