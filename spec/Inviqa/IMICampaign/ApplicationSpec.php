<?php

namespace spec\Inviqa\IMICampaign;

use Inviqa\IMICampaign\Application;
use Inviqa\IMICampaign\Configuration;
use PhpSpec\ObjectBehavior;

class ApplicationSpec extends ObjectBehavior
{
    function let(Configuration $configuration)
    {
        $configuration->isTestMode()->willReturn(true);
        $this->beConstructedWith($configuration);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Application::class);
    }
}
