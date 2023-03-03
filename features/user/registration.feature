Feature: Registration
  In order to create account
  As an user
  I need to be able to register

  Scenario: Correct registration on page
    Given I am on "/"
    When I follow "Zarejestruj się"
    And I fill in "Email" with "user@gmail.com"
    And I fill in "Hasło" with "1234567"
    And I press "Zarejestruj się"
    Then I should see "Mój profil"

  Scenario: Incorrect registration on page
    Given I am on "/"
    When I follow "Zarejestruj się"
    And I fill in "Email" with "user"
    And I fill in "Hasło" with "12367"
    And I press "Zarejestruj się"
    Then I should not see "Mój profil"
