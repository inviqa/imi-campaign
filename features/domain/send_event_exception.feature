Feature: An exception is thrown while an event request is sent to the API

  Scenario: An event request is successfully processed by the IMI Campaign Event API
    Given the event request for event ID "event-123" to event key "user+imicampaignerror@example.com" should throw an exception with message "Exceptional!"
    When an event request is made using event ID "event-123", event key "user+imicampaignerror@example.com" and the following event parameters:
      | first_name | John |
      | last_name  | Doe  |
    Then an IMI Campaign exception should have been thrown with the message "Exceptional!"
