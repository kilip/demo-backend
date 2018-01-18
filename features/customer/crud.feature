Feature: Adding a new customer
    In order to track information about my customers
    As an Administrator
    I want to manage a customer to the store

    Background:
        Given I am logged in employee
        And I have customer with data:
            | name                  | Customer Example       |
            | company               | Test Company           |

    Scenario: Adding a new customer
        Given I don't have customer named "Some Customer"
        And I send POST request to customers with body:
        """
        {
            "name": "Some Customer",
            "company": "Some Company"
        }
        """
        Then the response status code should be 201
        And the JSON node "name" should be equal to "Some Customer"
        And the JSON node "company" should be equal to "Some Company"

    Scenario: Get customer data
        Given I send GET request to customer "Customer Example"
        Then the response status code should be 200
        And the JSON node "name" should be equal to "Customer Example"
        And the JSON node "company" should be equal to "Test Company"

    Scenario: Update customer data
        Given I send PUT request to customer "Customer Example" with body:
        """
        {
            "company": "Edited Company",
            "email": "some@email.com"
        }
        """
        Then the response status code should be 200
        And the JSON node "name" should be equal to "Customer Example"
        And the JSON node "company" should be equal to "Edited Company"
        And the JSON node "email" should be equal to "some@email.com"

    Scenario: Delete customer data
        Given I have customer named "Deleted Customer"
        When I send DELETE request to customer "Deleted Customer"
        Then the response status code should be 204
