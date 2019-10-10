<?php

namespace Jawira\MiniGetopt;

use function getopt;

/**
 * Very simple `getopt()` wrapper
 *
 * @see     https://www.php.net/manual/en/function.getopt.php
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
class MiniGetopt
{
    /**
     * @var \Jawira\MiniGetopt\Value[]
     */
    protected $options = Value::EMPTY_ARRAY;

    /**
     * @var \Jawira\MiniGetopt\Validator
     */
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * Create an option with required value
     *
     * @param null|string $shortOption
     * @param null|string $longOption
     * @param string      $description
     * @param string      $placeholder
     *
     * @return $this
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function addRequired(?string $shortOption, ?string $longOption, string $description = Value::EMPTY_STRING,
                                string $placeholder = Value::PLACEHOLDER): self
    {
        $this->options[] = new RequiredValue($shortOption, $longOption, $description, $placeholder);

        return $this;
    }

    /**
     * Create an option with optional value
     *
     * @param null|string $shortOption
     * @param null|string $longOption
     * @param string      $description
     * @param string      $placeholder
     *
     * @return $this
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function addOptional(?string $shortOption, ?string $longOption, string $description = Value::EMPTY_STRING,
                                string $placeholder = Value::PLACEHOLDER): self
    {
        $this->options[] = new OptionalValue($shortOption, $longOption, $description, $placeholder);

        return $this;
    }

    /**
     * Create an option without value
     *
     * @param string $shortOption
     * @param string $longOption
     * @param string $description
     *
     * @return $this
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function addNoValue(string $shortOption, string $longOption, string $description = Value::EMPTY_STRING): self
    {
        $this->options[] = new NoValue($shortOption, $longOption, $description);

        return $this;
    }

    /**
     * Calls `getopt()` function
     *
     * @return array
     */
    public function getopt()
    {
        $shortOptions = Value::EMPTY_STRING;
        $longOptions  = Value::EMPTY_ARRAY;

        foreach ($this->options as $option) {
            $shortOptions .= $option->getShortOption();
            $long         = $option->getLongOption();
            if ($long !== Value::EMPTY_STRING) {
                $longOptions[] = $long;
            }
        }

        return getopt($shortOptions, $longOptions);
    }

    /** @noinspection PhpUnused */
    public function doc()
    {
        $doc = 'OPTIONS' . PHP_EOL . PHP_EOL;

        foreach ($this->options as $option) {
            $doc .= $option->doc() . PHP_EOL;
        }

        return $doc;
    }

    /**
     * @param string $shortOption
     * @param string $longOption
     *
     * @return mixed
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function getOption(string $shortOption, string $longOption)
    {
        if (!$this->validator->isShortOrLong($shortOption, $longOption)) {
            throw new MiniGetoptException('You should define at least short option or long option');
        }
        $getopt = $this->getopt();
        if (array_key_exists($shortOption, $getopt)) {
            return $getopt[$shortOption];
        }
        if (array_key_exists($longOption, $getopt)) {
            return $getopt[$longOption];
        }

        return null;
    }
}
