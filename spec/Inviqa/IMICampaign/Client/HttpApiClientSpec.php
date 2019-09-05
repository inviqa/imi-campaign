<?php

namespace spec\Inviqa\IMICampaign\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\StreamInterface;
use Inviqa\IMICampaign\Client\HttpApiClient;
use PhpSpec\ObjectBehavior;
use TestService\TestRequestFactory;
use TestService\TestResponseFactory;

class HttpApiClientSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_makes_requests_to_the_imi_api_and_returns_the_json_response_body(
        Client $client,
        Response $response,
        StreamInterface $body
    ) {
        $eventPayload = TestRequestFactory::buildEventJsonPayload();
        $eventResponse = TestResponseFactory::buildSuccessResponseJson();

        $requestOptions = ['body' => $eventPayload];

        $body->getContents()->willReturn($eventResponse);
        $response->getBody()->willReturn($body);
        $client->post(HttpApiClient::EVENT_ENDPOINT, $requestOptions)->willReturn($response);

        $this->sendEvent($eventPayload)->shouldBe($eventResponse);
    }
}
