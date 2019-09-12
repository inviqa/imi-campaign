<?php

namespace Inviqa\IMICampaign\CampaignSender;

use Inviqa\IMICampaign\Client\ApiClientFactory;
use Inviqa\IMICampaign\Configuration;
use Inviqa\IMICampaign\Request\EventFactory;
use Inviqa\IMICampaign\Response\ResponseParser;

class CampaignSenderFactory
{
    public static function buildFrom(Configuration $configuration): CampaignSender
    {
        $apiClient = ApiClientFactory::buildFrom($configuration);
        $eventFactory = new EventFactory();
        $responseParser = new ResponseParser();

        return new CampaignSender(
            $apiClient,
            $eventFactory,
            $responseParser
        );
    }
}
