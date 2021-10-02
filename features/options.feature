Feature: Using mini-getopt
  In order to read options
  As a user executing a cli command
  We need to be read options passed by user

  Scenario: Using invalid options
    Given I have the command "php resources/getopt.php --option --not-require"
    When I execute previous command
    Then I should have the following output:
    """
    array (
    )
    """

  Scenario: calling a short option with required value
    Given I have the command "php resources/getopt.php -f xml"
    When I execute previous command
    Then I should have the following output:
    """
    array (
      'f' => 'xml',
    )
    """

  Scenario: calling a one long option and two shorts options
    Given I have the command "php resources/getopt.php --format=xml -r -v"
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
    Given I have the command "php resources/getopt.php -f=json -r=yes -v"
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
    Given I have the command "php resources/getopt.php --retry -vvv"
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
    Given I have the command "php resources/getopt.php --version=banana --invalid"
    When I execute previous command
    Then I should have the following output:
    """
    array (
      'version' => false,
    )
    """

  Scenario:
    Given I have the command "php resources/optind.php --foo --bar --help"
    When I execute previous command
    Then I should have the following output:
    """
    optind: 4
    
    """

  Scenario:
    Given I have the command "php resources/doc.php"
    When I execute previous command
    Then I should have the following output:
    """
    Usage:
      test -r=demo
      test --optional --novalue
      test -n
    
    Options:
      -r --required=<value>  This is a required option
      -o --optional=[value]  This is an optional option
      -n --novalue           This has no value
    
    ********************
    This is a test command.
    
    Options:
      -r --required=<value>  This is a required option
      -o --optional=[value]  This is an optional option
      -n --novalue           This has no value
    
    ********************
    Options:
      -r --required=<value>  This is a required option
      -o --optional=[value]  This is an optional option
      -n --novalue           This has no value
    
    
    """


