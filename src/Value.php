<?php declare(strict_types=1);

namespace Jawira\MiniGetopt;

use function implode;
use function Jawira\TheLostFunctions\throw_unless;
use function sprintf;

/**
 * Class Value
 *
 * @internal
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
abstract class Value
{
    const PLACEHOLDER = 'value';
    const EMPTY_STRING = '';
    const EMPTY_ARRAY = [];

    /**
     * @var string Shot option string, one character long
     */
    protected $shortOption;

    /**
     * @var string Long option string, at least two characters
     */
    protected $longOption;

    /**
     * @var string Option's description, useful for documentation
     */
    protected $description;

    /**
     * @var string Placeholder to display in documentation, not used by \Jawira\MiniGetopt\NoValue
     */
    protected $placeholder;

    /**
     * Option constructor.
     *
     * @param string $shortOption One letter
     * @param string $longOption One word
     * @param string $description Option description
     * @param string $placeholder Placeholder for value in doc
     *
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function __construct(string $shortOption = self::EMPTY_STRING, string $longOption = self::EMPTY_STRING,
                                string $description = self::EMPTY_STRING, string $placeholder = self::PLACEHOLDER)
    {

        if (!Validator::isShortOrLong($shortOption, $longOption)) {
            throw new MiniGetoptException('You should define at least short option or long option');
        }

        if (Validator::isNotEmptyString($shortOption) && !Validator::isShortOption($shortOption)) {
            throw new MiniGetoptException('Invalid short option');
        }

        if (Validator::isNotEmptyString($longOption) && !Validator::isLongOption($longOption)) {
            throw new MiniGetoptException('Invalid short option');
        }

        $this->shortOption = $shortOption;
        $this->longOption  = $longOption;
        $this->description = $description;
        $this->placeholder = $placeholder;
    }

    /**
     * Get getopt compatible string for short option
     *
     * @return string
     */
    public function getShortOption(): string
    {
        return $this->shortOption . $this->getSeparator();
    }

    /**
     * Get getopt compatible string for long option
     *
     * @return string
     */
    public function getLongOption(): string
    {
        return $this->longOption . $this->getSeparator();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    abstract protected function getSeparator(): string;

    abstract protected function getDocTemplate(): string;

    public function getDocNames(): string
    {
        $names       = Value::EMPTY_ARRAY;
        $shortOption = $this->shortOption;
        $longOption  = $this->longOption;

        if (Validator::isNotEmptyString($shortOption)) {
            $names[] = "-$shortOption";
        }
        if (Validator::isNotEmptyString($longOption)) {
            $names[] = "--$longOption";
        }

        return sprintf($this->getDocTemplate(), implode(' ', $names), $this->placeholder);
    }
}
