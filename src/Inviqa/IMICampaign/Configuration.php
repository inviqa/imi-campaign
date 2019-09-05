<?php

namespace Inviqa\IMICampaign;

interface Configuration
{
    public function getDomain(): string;

    public function getApiToken(): string;

    public function isTestMode(): bool;

    public function getExtraConfig(): array;
}
