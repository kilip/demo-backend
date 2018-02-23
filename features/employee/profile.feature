Feature: Securing Employee Resource
    In order to manage Employee Profile Data
    As a rest api service
    I should be able manage employee profile

    Background:
        Given I don't have any employee data
        And I have employee with data:
            | name      | Lorem Ipsum             |
            | gender    | M                       |
            | address   | Some Street             |
            | email     | lorem.ipsum@example.com |
        And I have logout

    Scenario: Get data for another employee profile
        Given I am logged in employee
        And I send GET request to employee profile "Lorem Ipsum"
        Then the response status code should be 403
        And the JSON node "hydra:description" should be equal to "Access Denied."

    Scenario: Update data from another employee profile
        Given I am logged in employee
        And I send PUT request to employee profile "Lorem Ipsum" with body:
        """
        {
            "email": "some@email.com"
        }
        """
        Then the response status code should be 403
        And the JSON node "hydra:description" should be equal to "Access Denied."

    Scenario: Successfully updating employee profile
        Given I am logged in employee
        And I send GET request to employee profile "Omed Employee"
        Then the response status code should be 200
        And the JSON node "name" should be equal to "Omed Employee"

    Scenario: Successfully updating employee profile
        Given I am logged in employee
        And I send PUT request to employee profile "Omed Employee" with body:
        """
        {
            "email": "some-edited@email.com"
        }
        """
        Then the response status code should be 200
        And the JSON node "email" should be equal to "some-edited@email.com"
