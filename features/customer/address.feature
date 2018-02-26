Feature: Manage Employee Address
    In order to manage Customer Address
    As a client
    I need to be able to retrieve, create, update and delete them through the API.

    Background:
        Given I have customer with data:
            | name                   | Some Customer |
        And I am logged in employee

    Scenario: Add address to customer
        Given I send POST request to customer address for "Some Customer" with body:
        """
        {
            "address":"Some Street 2",
            "city": "Some City"
        }
        """
        Then the response status code should be 201
        And the JSON node address should be equal to "Some Street 2"
        And the JSON node city should be equal to "Some City"

    Scenario: Add invalid address to customer address
        Given I send POST request to customer address for "Some Customer" with body:
        """
        {
        }
        """
        Then the response status code should be 401
        And the JSON node "hydra:description" should contain "address: This value should not be blank."
        And the JSON node "hydra:description" should contain "city: This value should not be blank."

    Scenario: Update existing address
        Given I set header type to hydra
        And I have address for customer named "Some Customer"
        And I send PUT request to this current customer first address with:
        """
        {
            "address": "Edited Address"
        }
        """
        Then the response status code should be 200
        And the JSON node address should be equal to "Edited Address"

    Scenario: Update existing address
        Given I set header type to hydra
        And I have address for customer named "Some Customer"
        And I send PUT request to this current customer first address with:
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
        And I have address for customer named "Some Customer"
        And I send DELETE request to this current customer address
        Then the response status code should be 204
