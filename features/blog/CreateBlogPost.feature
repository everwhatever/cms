Feature: Create Blog Post
  As an administrator I want to have ability to create new posts

  Scenario: Create post as a logged in admin
    Given I am logged in as an admin
    When I am on "/"
    And I set post title to "new post"
    And I set post content to "very good content"
    And I click "save"
    Then I am redirected to "/post"
    And I see "new post"
    And I see "very good content"

  Scenario: Create post as a logged in normal user
    Given I am logged in as an user
    When I want to create new post
    Then I get forbidden error