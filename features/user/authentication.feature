Feature: Authentication
  In order to gain access to the site management area
  As an admin
  I need to be able to login

  Scenario: Logging in
    Given there is an admin user with email "admin@admin.pl" and password "admin"
    And I am on "/"
    When I follow "Zaloguj się"
    And I fill in "Email" with "admin@admin.pl"
    And I fill in "Hasło" with "admin"
    And I press "Zaloguj się"
    Then I should see "Linki Admina"

  Scenario: Logging out
    Given I am logged in as an admin
    When I follow "Wyloguj"
    Then I should see "Zaloguj"
