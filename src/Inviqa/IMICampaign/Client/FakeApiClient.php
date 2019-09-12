<?php

namespace Inviqa\IMICampaign\Client;

use Inviqa\IMICampaign\Configuration;
use Inviqa\IMICampaign\Request\Event\Event;

class FakeApiClient implements ApiClient
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function sendEvent(Event $event): string
    {
        $extraConfig = $this->configuration->getExtraConfig();

        $resultChecksum = md5($event->getEventId() . $event->getEventKey());

        $response = null;

        if (array_key_exists($resultChecksum, $extraConfig['testResults']['success'])) {
            $response = json_encode([
                'transaction-id' => $extraConfig['testResults']['success'][$resultChecksum],
            ]);
        }

        if (array_key_exists($resultChecksum, $extraConfig['testResults']['failure'])) {
            $response = json_encode([
                'code'        => $extraConfig['testResults']['failure'][$resultChecksum]['code'],
                'description' => $extraConfig['testResults']['failure'][$resultChecksum]['description'],
            ]);
        }

        if ($response === null) {
            throw new \RuntimeException(sprintf(
                'No matching predetermined result found for event ID %s and event key %s',
                $event->getEventId(),
                $event->getEventKey()
            ));
        }

        $this->triggerAfterSendCallbacks($extraConfig, $event);

        return $response;
    }

    private function triggerAfterSendCallbacks(array $extraConfig, Event $event)
    {
        foreach ($extraConfig['afterSendCallbacks'] as $afterSendCallback) {
            if (is_callable($afterSendCallback)) {
                $afterSendCallback($event);
            }
        }
    }
}
