Feature: Displaying users profiles
  In order to check users profiles
  As an admin user
  I need to be able to see all profiles

  Scenario: See all users when I am logged as admin
    Given I am logged in as an admin
    When I follow "Użytkownicy"
    And print last response
    Then I should see "Wszyscy użytkownicy"
    And I should see "admin@admin.pl"

  Scenario: I can't see all users when I am not logged in as admin
    Given I am on "/"
    And I should not see "Użytkownicy"
    When I go to "/users"
    Then I should be on "/login"
