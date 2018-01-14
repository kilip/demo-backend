@employee
Feature: Manage Employees
    In order to manage Employee
    As a client
    I need to be able to retrieve, create, update and delete them through the API.

    Background:
        Given I don't have any employee data
        And I have employee with data:
            | name      | Lorem Ipsum |
            | gender    | M           |
        And I am logged in as admin

    Scenario: Create employee
        When I send POST request to employees with body:
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

    Scenario: Browse the employee list
        When I send GET request to employees
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
        And the JSON should be valid according to this schema:
        """
        {
            "$schema": "http://json-schema.org/draft-03/schema#",
            "type": "object",
            "additionalProperties": false,
            "required": true,
            "properties": {
                "@context": {"type": "string"},
                "@id": {"type": "string"},
                "@type": {"type": "string"},
                "id": { "type": "string"},
                "name": { "type": "string"},
                "hydra:member": {"type": "array"},
                "hydra:totalItems": {"type": "number"}
            }
        }
        """

    Scenario: Update employee data
        When I send PUT request to employee "Lorem Ipsum" with body:
        """
        {
          "name": "Some Edited Name",
          "birthDate": "1980-07-21",
          "gender": "M",
          "email": "some-edited@example.com"
        }
        """
        Then the response status code should be 200
        And the response should be in JSON
        And the JSON nodes should contain:
        | name      | Some Edited Name        |
        | gender    | M                       |
        | birthDate | 1980-07-21              |
        | email     | some-edited@example.com |

    Scenario: Update with invalid data
        When I send PUT request to employee "Lorem Ipsum" with body:
        """
        {
          "name": "Some Name",
          "birthDate": "1981-07-21",
          "gender": "T",
          "email": "someexample.com"
        }
        """
        Then the response status code should be 400
        And the JSON should be equal to:
        """
        {
            "@context": "/contexts/ConstraintViolationList",
            "@type": "ConstraintViolationList",
            "hydra:title": "An error occurred",
            "hydra:description": "gender: Choose a valid gender type 'M' or 'F'\nemail: This value is not a valid email address.",
            "violations": [
                {
                    "propertyPath": "gender",
                    "message": "Choose a valid gender type 'M' or 'F'"
                },
                {
                    "propertyPath": "email",
                    "message": "This value is not a valid email address."
                }
            ]
        }
        """

    Scenario: Delete employee
        When I send DELETE request to employee "Lorem Ipsum"
        Then the response status code should be 204
