<?php

namespace Inviqa\IMICampaign\Client;

use GuzzleHttp\Client;

class HttpApiClient implements ApiClient
{
    public const EVENT_ENDPOINT = 'imicampaignapi/resources/v3/events';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendEvent(string $eventJsonPayload): string
    {
        $response = $this->client->post(self::EVENT_ENDPOINT, [
            'body' => $eventJsonPayload,
        ]);

        return $response->getBody()->getContents();
    }
}
