Feature: Manage Employee Address
    In order to manage Employee Address
    As a client
    I need to be able to retrieve, create, update and delete them through the API.

    Background:
        Given I don't have any employee data
        And I have employee with data:
            | name      | Lorem Ipsum |
            | gender    | M           |


    Scenario: Add new address to employee
        Given I set header type to hydra
        And I send a "POST" request to "/api/addresses/employee/1" with body:
        """
        {
            "address":"Some Street",
            "city": "Some City"
        }
        """
        Then the response status code should be 201
        And the JSON node address should be equal to "Some Street"
