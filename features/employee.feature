Feature: Manage Employees
  In order to manage Employee
  As a client
  I need to be able to retrieve, create, update and delete them through the API.

  @createSchema
  Scenario: Create employee
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/employees" with body:
    """
    {
      "name": "Some Name",
      "birthDate": "1980-07-21",
      "gender": "M",
      "email": "some@example.com"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node name should be equal to "Some Name"
    And the JSON node "gender" should be equal to "M"
    And the JSON node email should be equal to "some@example.com"