<?php

namespace Inviqa\IMICampaign;

use Inviqa\IMICampaign\CampaignSender\CampaignSenderFactory;

class Application
{
    private $campaignSender;

    public function __construct(Configuration $configuration)
    {
        $this->campaignSender = CampaignSenderFactory::buildFrom($configuration);
    }

    public function sendEvent(string $eventId, string $eventKey, array $eventParameters)
    {
        return $this->campaignSender->sendEvent($eventId, $eventKey, $eventParameters);
    }
}
