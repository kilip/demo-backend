Feature: Manage Employee Address
    In order to manage Employee Address
    As a client
    I need to be able to retrieve, create, update and delete them through the API.

    Background:
        Given I don't have any employee data
        And I have employee with data:
            | name      | Lorem Ipsum |
            | gender    | M           |
            | address   | Some Street |
        And I am logged in as admin

    Scenario: Add address to employee
        Given I send POST request to add employee address for "Lorem Ipsum" with body:
        """
        {
            "address":"Some Street 2",
            "city": "Some City"
        }
        """
        Then the response status code should be 201
        And the JSON node address should be equal to "Some Street 2"

    Scenario: Add invalid address to employee
        Given I send POST request to add employee address for "Lorem Ipsum" with body:
        """
        {
        }
        """
        Then the response status code should be 401
        And the JSON node "hydra:description" should contain "address: This value should not be blank."
        And the JSON node "hydra:description" should contain "city: This value should not be blank."

    Scenario: Browse employee address
        Given I request addresses for employee "Lorem Ipsum"
        Then the response status code should be 200
        And the JSON node "hydra:totalItems" should be equal to 1
        And the JSON node "@type" should be equal to "hydra:Collection"

    Scenario: Update existing address
        Given I set header type to hydra
        And I have address for employee named "Lorem Ipsum"
        And I send PUT request to his first address with:
        """
        {
            "address": "Edited Address"
        }
        """
        Then the response status code should be 200
        And the JSON node address should be equal to "Edited Address"

    Scenario: Update with invalid data type
        Given I set header type to hydra
        And I have address for employee named "Lorem Ipsum"
        And I send PUT request to his first address with:
        """
        {
            "address": "Edited Address",
            "country": "Foo Bar"
        }
        """
        Then the response status code should be 400
        And the JSON node "hydra:description" should contain "country: This value is not a valid country."

    Scenario: Update with invalid data type
        Given I set header type to hydra
        And I have address for employee named "Lorem Ipsum"
        And I send DELETE request to his first address
        Then the response status code should be 204
