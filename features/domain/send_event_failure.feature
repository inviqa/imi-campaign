Feature: A event request is sent to the API but returns an error

  Scenario: An event request is not successfully processed by the IMI Campaign Event API
    Given the event request for event ID "event-123" to event key "user@example.com" should fail with code "1001" and description "Invalid input JSON"
    When an event request is made using event ID "event-123", event key "user@example.com" and the following event parameters:
      | first_name | John |
      | last_name  | Doe  |
    Then the result of the request should be a failure and contain code "1001" and description "Invalid input JSON"
