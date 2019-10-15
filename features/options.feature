Feature: Using mini-getopt
  In order to read options
  As a user executing a cli command
  We need to be read options passed by user

  Scenario: Using invalid options
    Given I have the command "php resources/example.php --option --not-require"
    When I execute previous command
    Then I should have the following output:
    """
    array (
    )
    """

  Scenario: calling a short option with required value
    Given I have the command "php resources/example.php -f xml"
    When I execute previous command
    Then I should have the following output:
    """
    array (
      'f' => 'xml',
    )
    """


  Scenario: calling a one long option and two shorts options
    Given I have the command "php resources/example.php --format=xml -r -v"
    When I execute previous command
    Then I should have the following output:
    """
    array (
      'format' => 'xml',
      'r' => false,
      'v' => false,
    )
    """


  Scenario:
    Given I have the command "php resources/example.php -f=json -r=yes -v"
    When I execute previous command
    Then I should have the following output:
    """
    array (
      'f' => 'json',
      'r' => 'yes',
      'v' => false,
    )
    """




  Scenario:
    Given I have the command "php resources/example.php --retry -vvv"
    When I execute previous command
    Then I should have the following output:
    """
    array (
      'retry' => false,
      'v' => 
      array (
        0 => false,
        1 => false,
        2 => false,
      ),
    )
    """



  Scenario:
    Given I have the command "php resources/example.php --version=banana --invalid"
    When I execute previous command
    Then I should have the following output:
    """
    array (
      'version' => false,
    )
    """


