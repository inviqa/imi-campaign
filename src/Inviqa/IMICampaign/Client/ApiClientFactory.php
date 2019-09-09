<?php

namespace Inviqa\IMICampaign\Client;

use GuzzleHttp\Client;
use Inviqa\IMICampaign\Configuration;

class ApiClientFactory
{
    public static function buildFrom(Configuration $configuration): ApiClient
    {
        if ($configuration->isTestMode()) {
            return new FakeApiClient($configuration);
        }

        $guzzleClient = new Client([
            'base_url'   => $configuration->getDomain(),
            'defaults'   => [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $configuration->getApiToken()),
                    'Content-Type'  => 'application/json',
                ],
            ],
        ]);

        return new HttpApiClient($guzzleClient);
    }
}
