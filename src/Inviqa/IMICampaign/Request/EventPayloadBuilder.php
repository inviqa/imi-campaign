<?php

namespace Inviqa\IMICampaign\Request;

class EventPayloadBuilder
{
    private $jsonConverter;
    private $eventFactory;

    public function __construct(
        EventFactory $eventFactory,
        JsonConverter $jsonConverter
    ) {
        $this->eventFactory = $eventFactory;
        $this->jsonConverter = $jsonConverter;
    }

    public function buildFrom(string $eventId, string $eventKey, array $eventParameters): string
    {
        return $this->jsonConverter->convert(
            $this->eventFactory->buildFrom(
                $eventId,
                $eventKey,
                $eventParameters
            )
        );
    }
}
