<?php

namespace Inviqa\IMICampaign\CampaignSender;

use Exception;
use Inviqa\IMICampaign\Client\ApiClient;
use Inviqa\IMICampaign\Exception\IMICampaignException;
use Inviqa\IMICampaign\Request\EventFactory;
use Inviqa\IMICampaign\Response\EventResult;
use Inviqa\IMICampaign\Response\ResponseParser;

class CampaignSender
{
    private $apiClient;
    private $eventFactory;
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

    public function sendEvent(string $eventId, string $eventKey, array $eventParameters): EventResult
    {
        try {
            $event = $this->eventFactory->buildFrom($eventId, $eventKey, $eventParameters);
            $responseBody = $this->apiClient->sendEvent($event);
            return $this->responseParser->extractEventResultFrom($responseBody);
        } catch (Exception $e) {
            throw new IMICampaignException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
