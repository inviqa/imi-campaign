<?php

namespace Inviqa\IMICampaign\Client;

use Inviqa\IMICampaign\Request\Event\Event;

interface ApiClient
{
    public function sendEvent(Event $event): string;
}
