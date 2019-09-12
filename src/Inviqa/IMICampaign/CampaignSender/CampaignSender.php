<?php

namespace Inviqa\IMICampaign\CampaignSender;

use Inviqa\IMICampaign\Client\ApiClient;
use Inviqa\IMICampaign\Request\EventFactory;
use Inviqa\IMICampaign\Response\ResponseParser;

class CampaignSender
{
    private $apiClient;
    private $responseParser;

    public function __construct(
        ApiClient $apiClient,
        EventFactory $eventFactory,
        ResponseParser $responseParser
    ) {
        $this->apiClient = $apiClient;
        $this->eventFactory = $eventFactory;
        $this->responseParser = $responseParser;
    }

    public function sendEvent(string $eventId, string $eventKey, array $eventParameters)
    {
        $event = $this->eventFactory->buildFrom($eventId, $eventKey, $eventParameters);
        $responseBody = $this->apiClient->sendEvent($event);
        return $this->responseParser->extractEventResultFrom($responseBody);
    }
}
