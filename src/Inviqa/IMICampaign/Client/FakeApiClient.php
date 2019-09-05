<?php

namespace Inviqa\IMICampaign\Client;

use Inviqa\IMICampaign\Configuration;
use function call_user_func_array;

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

    public function sendEvent(string $eventJsonPayload): string
    {
        $extraConfig = $this->configuration->getExtraConfig();

        $decodedPayload = json_decode($eventJsonPayload, true);

        $resultChecksum = md5($decodedPayload['event-id'] . $decodedPayload['event-key']);

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
                $decodedPayload['event-id'],
                $decodedPayload['event-key']
            ));
        }

        $this->triggerAfterSendCallbacks($extraConfig, $eventJsonPayload);

        return $response;
    }

    private function triggerAfterSendCallbacks(array $extraConfig, string $eventJsonPayload)
    {
        foreach ($extraConfig['afterSendCallbacks'] as $afterSendCallback) {
            if (is_callable($afterSendCallback)) {
                $afterSendCallback($eventJsonPayload);
            }
        }
    }
}
