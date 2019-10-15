<?php /** @noinspection PhpUnused */

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;

class FeatureContext implements Context
{
    protected $command;
    protected $output;

    /**
     * @Given I have the command :myCommand
     *
     * @param string $myCommand Command to execute
     */
    public function iHaveTheCommand($myCommand)
    {
        $this->command = $myCommand;
    }

    /**
     * @When I execute previous command
     */
    public function iExecutePreviousCommand()
    {
        $this->output = shell_exec($this->command);

    }

    /**
     * @Then I should have the following output:
     *
     * @param \Behat\Gherkin\Node\PyStringNode $expected Expected output
     *
     * @throws \Exception
     */
    public function iShouldHaveTheFollowingOutput(PyStringNode $expected)
    {
        $expectedString = (string)$expected;
        $output = $this->output;

        if ($expectedString !== $output) {
            throw new Exception("Output don't match with expected string");
        }
    }
}
