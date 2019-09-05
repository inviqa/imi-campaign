<?php

namespace Inviqa\IMICampaign\CampaignSender;

use Inviqa\IMICampaign\Client\ApiClientFactory;
use Inviqa\IMICampaign\Configuration;
use Inviqa\IMICampaign\Request\EventFactory;
use Inviqa\IMICampaign\Request\EventPayloadBuilder;
use Inviqa\IMICampaign\Request\JsonConverter;
use Inviqa\IMICampaign\Response\ResponseParser;

class CampaignSenderFactory
{
    public static function buildFrom(Configuration $configuration): CampaignSender
    {
        $apiClient = ApiClientFactory::buildFrom($configuration);
        $eventPayloadBuilder = new EventPayloadBuilder(
            new EventFactory(),
            new JsonConverter()
        );
        $responseParser = new ResponseParser();

        return new CampaignSender(
            $apiClient,
            $eventPayloadBuilder,
            $responseParser
        );
    }
}
