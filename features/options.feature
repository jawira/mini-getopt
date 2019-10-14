Feature: Internal operations
  In order to read options
  As a user executing a cli command
  We need to be read options passed by user

  Scenario: Using
    Given I have the command "php resources/example.php --option --not-require"
    When I execute previous command
    Then I should have the following output:
    """
    array(
    )

    """
