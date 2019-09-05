<?php

namespace spec\Inviqa\IMICampaign\CampaignSender;

use Inviqa\IMICampaign\CampaignSender\CampaignSender;
use Inviqa\IMICampaign\Configuration;
use PhpSpec\ObjectBehavior;

class CampaignSenderFactorySpec extends ObjectBehavior
{
    function it_builds_and_returns_a_campaign_sender(Configuration $configuration)
    {
        $configuration->getDomain()->willReturn('https://email.example.com');
        $configuration->getApiToken()->willReturn('token_123');
        $configuration->isTestMode()->willReturn(false);

        $this::buildFrom($configuration)->shouldBeAnInstanceOf(CampaignSender::class);
    }
}
