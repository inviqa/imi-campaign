<?php

namespace Domain;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\IMICampaign\Application;
use Inviqa\IMICampaign\Exception\IMICampaignException;
use Inviqa\IMICampaign\Response\EventResult;
use TestService\TestConfiguration;
use Webmozart\Assert\Assert;

class IMICampaignEventContext implements Context
{
    private const EXPECTED_SUCCESS_TRANSACTION_ID = 'evt_123';

    /**
     * @var EventResult|null
     */
    private $eventResult;

    /**
     * @var IMICampaignException|null
     */
    private $imiCampaignException;
    private $configuration;
    private $application;

    public function __construct()
    {
        $this->configuration = new TestConfiguration();
        $this->application = new Application($this->configuration);
    }

    /**
     * @Given the event request for event ID :arg1 to event key :arg2 should succeed
     */
    public function theEventRequestForEventIdToEventKeyShouldSucceed(string $eventId, string $eventKey)
    {
        $this->configuration->addSuccessEvent($eventId, $eventKey, self::EXPECTED_SUCCESS_TRANSACTION_ID);
    }

    /**
     * @Given the event request for event ID :arg1 to event key :arg2 should fail with code :arg3 and description :arg4
     */
    public function theEventRequestForEventIdToEventKeyShouldFailWithCodeAndDescription(string $eventId, string $eventKey, int $apiResponseCode, string $errorDescription)
    {
        $this->configuration->addFailureEvent($eventId, $eventKey, $apiResponseCode, $errorDescription);
    }

    /**
     * @Given the event request for event ID :arg1 to event key :arg2 should throw an exception with message :arg3
     */
    public function theEventRequestForEventIdToEventKeyShouldThrowAnExceptionWithMessage(string $eventId, string $eventKey, string $exceptionMessage)
    {
        $this->configuration->addException($eventId, $eventKey, $exceptionMessage);
    }

    /**
     * @When an event request is made using event ID :arg1, event key :arg2 and the following event parameters:
     */
    public function anEventRequestIsMadeUsingEventIdEventKeyAndTheFollowingEventParameters(string $eventId, string $eventKey, TableNode $eventParameters)
    {
        try {
            $this->eventResult = $this->application->sendEvent($eventId, $eventKey, $eventParameters->getRowsHash());
        } catch (IMICampaignException $e) {
            $this->imiCampaignException = $e;
        }
    }

    /**
     * @Then the result of the request should be successful and contain a transaction ID
     */
    public function theResultOfTheRequestShouldBeSuccessfulAndContainATransactionId()
    {
        Assert::eq($this->eventResult->getTransactionId(), self::EXPECTED_SUCCESS_TRANSACTION_ID);
        Assert::eq($this->eventResult->getApiResponseCode(), EventResult::SUCCESS_API_RESPONSE_CODE);
    }

    /**
     * @Then the result of the request should be a failure and contain code :arg1 and description :arg2
     */
    public function theResultOfTheRequestShouldBeAFailureAndContainCodeAndDescription(int $apiResponseCode, string $description)
    {
        Assert::eq($this->eventResult->getApiResponseCode(), $apiResponseCode);
        Assert::eq($this->eventResult->getDescription(), $description);
    }

    /**
     * @Then an IMI Campaign exception should have been thrown with the message :arg1
     */
    public function anIMICampaignExceptionShouldHaveBeenThrown(string $exceptionMessage)
    {
        Assert::isInstanceOf($this->imiCampaignException, IMICampaignException::class);
        Assert::eq($this->imiCampaignException->getMessage(), $exceptionMessage);
    }
}
