<?php

namespace Jawira\MiniGetopt;

use function getopt;

/**
 * Very simple `getopt()` wrapper
 *
 * @see     https://www.php.net/manual/en/function.getopt.php
 * @package Jawira\MiniGetopt
 */
class MiniGetopt
{
    /**
     * @var \Jawira\MiniGetopt\Value[]
     */
    protected $options = [];

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
    public function addRequired(?string $shortOption, ?string $longOption, string $description = Value::EMPTY, string $placeholder = Value::PLACEHOLDER): self
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
    public function addOptional(?string $shortOption, ?string $longOption, string $description = Value::EMPTY, string $placeholder = Value::PLACEHOLDER): self
    {
        $this->options[] = new OptionalValue($shortOption, $longOption, $description, $placeholder);

        return $this;
    }

    /**
     * Create an option without value
     *
     * @param null|string $shortOption
     * @param null|string $longOption
     * @param string      $description
     *
     * @return $this
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function addNoValue(?string $shortOption, ?string $longOption, string $description = Value::EMPTY): self
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
        $shortOptions = '';
        $longOptions  = [];

        foreach ($this->options as $option) {
            $shortOptions .= $option->getShortOption();
            $long         = $option->getLongOption();
            if ($long !== Value::EMPTY) {
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
     * @param string $short
     * @param string $long
     *
     * @return null|bool|string
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     */
    public function getOption(?string $short, ?string $long)
    {
        $this->validator->validateShortAndLong($short, $long);
        $getopt = $this->getopt();
        if (array_key_exists($short, $getopt)) {
            return $getopt[$short];
        }
        if (array_key_exists($long, $getopt)) {
            return $getopt[$long];
        }

        return null;
    }
}
