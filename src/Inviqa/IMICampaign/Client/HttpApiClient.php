<?php

namespace Inviqa\IMICampaign\Client;

use GuzzleHttp\Client;
use Inviqa\IMICampaign\Request\Event\Event;

class HttpApiClient implements ApiClient
{
    public const EVENT_ENDPOINT = 'imicampaignapi/resources/v3/events';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendEvent(Event $event): string
    {
        $response = $this->client->post(self::EVENT_ENDPOINT, [
            'body'       => $event->toJson(),
            'exceptions' => false,
        ]);

        return $response->getBody()->getContents();
    }
}
