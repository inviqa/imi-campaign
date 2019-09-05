<?php

namespace Inviqa\IMICampaign\CampaignSender;

use Inviqa\IMICampaign\Client\ApiClient;
use Inviqa\IMICampaign\Request\EventPayloadBuilder;
use Inviqa\IMICampaign\Response\ResponseParser;

class CampaignSender
{
    private $apiClient;
    private $eventPayloadBuilder;
    private $responseParser;

    public function __construct(
        ApiClient $apiClient,
        EventPayloadBuilder $eventPayloadBuilder,
        ResponseParser $responseParser
    ) {
        $this->apiClient = $apiClient;
        $this->eventPayloadBuilder = $eventPayloadBuilder;
        $this->responseParser = $responseParser;
    }

    public function sendEvent(string $eventId, string $eventKey, array $eventParameters)
    {
        $eventPayload = $this->eventPayloadBuilder->buildFrom($eventId, $eventKey, $eventParameters);
        $responseBody = $this->apiClient->sendEvent($eventPayload);
        return $this->responseParser->extractEventResultFrom($responseBody);
    }
}
