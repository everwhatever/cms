Feature: Edition
  I order to change my personal data
  As an logged in user
  I need to be able to edit my account data

  Scenario: I edit my profile
    Given I am logged in as a user
    When I follow "Edycja profilu"
    And I fill in "Imię" with "Jakub"
    And I fill in "Nazwisko" with "Fakej"
    And I fill in "Numer tel" with "136343374"
    And I press "Zaktualizuj"
    Then I should see "Jakub"
    Then I should see "Fakej"
