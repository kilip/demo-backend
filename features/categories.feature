Feature: Manage Categories
  In order to manage product categories
  As a client
  I need to be able to retrieve, create, update and delete them through the API.

  @createSchema
  Scenario: Create category
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/categories" with body:
    """
    {
      "name": "New Category",
      "description": "New Product Category"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "@context": "/api/contexts/Categories",
      "@id": "/api/categories/1",
      "@type": "Categories",
      "id": 1,
      "name": "New Category",
      "description": "New Product Category",
      "picture": null
    }
    """

  Scenario: Retrieve categories list
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/categories"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "@context": "/api/contexts/Categories",
      "@id": "/api/categories",
      "@type": "hydra:Collection",
      "hydra:member":[
        {
          "@id": "/api/categories/1",
          "@type": "Categories",
          "id": 1,
          "name": "New Category",
          "description": "New Product Category",
          "picture": null
        }
      ],
      "hydra:totalItems": 1
    }
    """

  @dropSchema
  Scenario: Throw errors when category is invalid
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/categories" with body:
    """
    {
      "description": "New Product Category"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "@context": "/api/contexts/ConstraintViolationList",
      "@type": "ConstraintViolationList",
      "hydra:title": "An error occurred",
      "hydra:description": "name: This value should not be blank.",
      "violations": [
        {
          "propertyPath": "name",
          "message": "This value should not be blank."
        }
      ]
    }
    """