Feature: Securing Employee Resource
    In order to secure Employee data
    As a rest api service
    I should be able manage authentication

    Background:
        Given I have employee with data:
            | name      | Lorem Ipsum             |
            | gender    | M                       |
            | address   | Some Street             |
            | email     | lorem.ipsum@example.com |
        And I have logout

    Scenario: Anonymously Browsing Employee data
        Given I send GET request to employees
        Then the response status code should be 401

    Scenario: Anonymously Create Employee Data
        Given I send POST request to employees with body:
        """
        {
            "name": "Some Name",
            "gender": "M"
        }
        """
        Then the response status code should be 401

    Scenario: Anonymously get Employee Data
        Given I send GET request to employee "Lorem Ipsum"
        Then the response status code should be 401
        When I am logged in as admin
        And I send GET request to employee "Lorem Ipsum"
        Then the response status code should be 200

    Scenario: Successfully get employee data
        Given I am logged in employee
        And I send GET request to employee "Omed Employee"
        Then the response status code should be 200
        And the JSON node name should be equal to "Omed Employee"

    Scenario: Can not POST new employee with employee role
        Given I am logged in employee
        And I send POST request to employees with body:
        """
        {
          "name": "Some Name",
          "birthDate": "1980-07-21",
          "gender": "M",
          "email": "some@example.com"
        }
        """
        Then the response status code should be 403
        And the JSON node "hydra:description" should be equal to "Access Denied."

    Scenario: Update another employee data
        Given I am logged in employee
        And I send PUT request to employee "Lorem Ipsum" with body:
        """
        {
            "address": "Some Address Edited"
        }
        """
        Then the response status code should be 403
        And the JSON node "hydra:description" should be equal to "Access Denied."

    Scenario: Fail to delete employee data with employee role
        Given I am logged in employee
        And I send DELETE request to employee "Lorem Ipsum"
        Then the response status code should be 403
        And the JSON node "hydra:description" should be equal to "Access Denied."
