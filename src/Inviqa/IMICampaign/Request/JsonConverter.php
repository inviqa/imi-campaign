<?php

namespace Inviqa\IMICampaign\Request;

use JsonSerializable;
use function json_encode;

class JsonConverter
{
    public function convert(JsonSerializable $jsonSerializable): string
    {
        return json_encode($jsonSerializable);
    }
}
