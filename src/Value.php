<?php

namespace Jawira\MiniGetopt;

/**
 * Class Value
 *
 * @internal
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
abstract class Value
{
    const NO_VALUE    = '';
    const REQUIRED    = ':';
    const OPTIONAL    = '::';
    const PLACEHOLDER = 'value';
    const EMPTY       = '';

    /**
     * @var null|string Shot option string, one character long
     */
    protected $shortOption;

    /**
     * @var null|string Long option string, at least two characters
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
     * @var \Jawira\MiniGetopt\Validator
     */
    protected $validator;

    /**
     * Option constructor.
     *
     * @param null|string $shortOption
     * @param null|string $longOption
     * @param string      $description
     * @param string      $placeholder
     *
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function __construct(?string $shortOption, ?string $longOption, string $description = self::EMPTY,
                                string $placeholder = self::PLACEHOLDER)
    {
        $this->validator = new Validator();
        $this->validator->validateShortAndLong($shortOption, $longOption);
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
        if (is_null($this->shortOption)) {
            return self::EMPTY;
        }

        return $this->shortOption . $this->getSeparator();
    }

    /**
     * Get getopt compatible string for long option
     *
     * @return string
     */
    public function getLongOption(): string
    {
        if (is_null($this->shortOption)) {
            return self::EMPTY;
        }

        return $this->longOption . $this->getSeparator();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    abstract protected function getSeparator(): string;

    abstract protected function getDocTemplate(): string;

    public function doc()
    {
        $names       = [];
        $shortOption = $this->shortOption;
        $longOption  = $this->longOption;
        $placeholder = $this->getPlaceholder();
        $description = $this->getDescription();

        if ($this->validator->isNotEmptyString($shortOption)) {
            $names[] = "-$shortOption";
        }
        if ($this->validator->isNotEmptyString($longOption)) {
            $names[] = "--$longOption";
        }

        return sprintf($this->getDocTemplate(), implode(', ', $names), $placeholder, wordwrap($description, 72, PHP_EOL));
    }
}
