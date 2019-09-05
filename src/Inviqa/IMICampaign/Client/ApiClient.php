<?php

namespace Inviqa\IMICampaign\Client;

interface ApiClient
{
    public function sendEvent(string $eventJsonPayload): string;
}
