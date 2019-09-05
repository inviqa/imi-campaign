<?php

namespace spec\Inviqa\IMICampaign\Client;

use Inviqa\IMICampaign\Client\FakeApiClient;
use Inviqa\IMICampaign\Client\HttpApiClient;
use Inviqa\IMICampaign\Configuration;
use PhpSpec\ObjectBehavior;

class ApiClientFactorySpec extends ObjectBehavior
{
    function it_builds_a_real_api_client_when_not_in_test_mode(Configuration $configuration)
    {
        $configuration->isTestMode()->willReturn(false);
        $configuration->getDomain()->willReturn('https://email.example.com');
        $configuration->getApiToken()->willReturn('token_123');

        $this::buildFrom($configuration)->shouldBeAnInstanceOf(HttpApiClient::class);
    }

    function it_builds_a_fake_api_client_when_not_in_test_mode(Configuration $configuration)
    {
        $configuration->isTestMode()->willReturn(true);

        $this::buildFrom($configuration)->shouldBeAnInstanceOf(FakeApiClient::class);
    }
}
