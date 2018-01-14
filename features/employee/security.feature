Feature: Securing Employee Resource
    In order to secure Employee data
    As a rest api service
    I should be able manage authentication

    Background:
        Given I don't have any employee data
        And I have employee with data:
            | name      | Lorem Ipsum |
            | gender    | M           |
            | address   | Some Street |
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
