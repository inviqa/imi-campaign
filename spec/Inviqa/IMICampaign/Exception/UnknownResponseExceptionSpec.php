<?php

namespace spec\Inviqa\IMICampaign\Exception;

use Inviqa\IMICampaign\Exception\UnknownResponseException;
use PhpSpec\ObjectBehavior;

class UnknownResponseExceptionSpec extends ObjectBehavior
{
    const EXAMPLE_RESPONSE_BODY = 'Erroneous response body!';

    function it_can_easily_be_constructed_with_the_response_body()
    {
        $this->beConstructedWithResponseBody(self::EXAMPLE_RESPONSE_BODY);
        $this->getMessage()->shouldBe(sprintf(UnknownResponseException::UNKNOWN_RESPONSE_MESSAGE, self::EXAMPLE_RESPONSE_BODY));
    }
}
