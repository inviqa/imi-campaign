<?php

namespace spec\Inviqa\IMICampaign\Response;

use PhpSpec\ObjectBehavior;

class EventResultSpec extends ObjectBehavior
{
    function it_returns_a_success_result_and_transaction_id()
    {
        $this->beConstructedsuccessFromTransactionId('event_12345676543210');
        $this->isSuccess()->shouldBe(true);
        $this->isFailure()->shouldBe(false);
        $this->getTransactionId()->shouldBe('event_12345676543210');
        $this->getApiResponseCode()->shouldBe(200);
    }

    function it_returns_a_failure_result_and_api_response_code()
    {
        $this->beConstructedfailureFromApiResponseCodeAndDescription(500, 'Invalid input JSON');
        $this->isSuccess()->shouldBe(false);
        $this->isFailure()->shouldBe(true);
        $this->getTransactionId()->shouldBe(null);
        $this->getApiResponseCode()->shouldBe(500);
        $this->getDescription()->shouldBe('Invalid input JSON');
    }
}
