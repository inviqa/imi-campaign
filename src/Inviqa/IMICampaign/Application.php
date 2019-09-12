<?php

namespace Inviqa\IMICampaign;

use Inviqa\IMICampaign\CampaignSender\CampaignSenderFactory;
use Inviqa\IMICampaign\Response\EventResult;

class Application
{
    private $campaignSender;

    public function __construct(Configuration $configuration)
    {
        $this->campaignSender = CampaignSenderFactory::buildFrom($configuration);
    }

    public function sendEvent(string $eventId, string $eventKey, array $eventParameters): EventResult
    {
        return $this->campaignSender->sendEvent($eventId, $eventKey, $eventParameters);
    }
}
