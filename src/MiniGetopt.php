<?php declare(strict_types=1);

namespace Jawira\MiniGetopt;

use function array_map;
use function array_reduce;
use function count;
use function exp;
use function explode;
use function getopt;
use function implode;
use function is_array;
use function max;
use function mb_strlen;
use function str_pad;
use const PHP_EOL;

/**
 * Very simple `getopt()` wrapper
 *
 * @see     https://www.php.net/manual/en/function.getopt.php
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
class MiniGetopt
{
    /** @var \Jawira\MiniGetopt\Value[] */
    protected $options = Value::EMPTY_ARRAY;

    /**
     * Create an option with required value
     *
     * @param string $shortOption
     * @param string $longOption
     * @param string $description
     * @param string $placeholder
     *
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     * @return $this
     */
    public function addRequired(string $shortOption = Value::EMPTY_STRING, string $longOption = Value::EMPTY_STRING,
                                string $description = Value::EMPTY_STRING,
                                string $placeholder = Value::PLACEHOLDER): self
    {
        $this->options[] = new RequiredValue($shortOption, $longOption, $description, $placeholder);

        return $this;
    }

    /**
     * Create an option with optional value
     *
     * @param string $shortOption
     * @param string $longOption
     * @param string $description
     * @param string $placeholder
     *
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     * @return \Jawira\MiniGetopt\MiniGetopt
     */
    public function addOptional(string $shortOption = Value::EMPTY_STRING, string $longOption = Value::EMPTY_STRING,
                                string $description = Value::EMPTY_STRING,
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
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     * @return $this
     */
    public function addNoValue(string $shortOption = Value::EMPTY_STRING, string $longOption = Value::EMPTY_STRING,
                               string $description = Value::EMPTY_STRING): self
    {
        $this->options[] = new NoValue($shortOption, $longOption, $description);

        return $this;
    }

    /**
     * Calls `getopt()` function
     *
     * @param mixed $optind The index where argument parsing stopped will be written to this variable.
     *
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     *
     * @return array<string, false|list<mixed>|string>
     */
    public function getopt(&$optind = null): array
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

        $getopt = getopt($shortOptions, $longOptions, $optind);
        if (!is_array($getopt)) {
            throw new MiniGetoptException('Failure when running getopt function');
        }

        return $getopt;
    }

    /**
     * @noinspection PhpUnused
     * @see          http://docopt.org/
     *
     * @param string[] $usages
     */
    public function doc(string $description = '', array $usages = []): string
    {
        $doc = $description ? $description . PHP_EOL . PHP_EOL : '';
        $doc .= $this->assembleUsage($usages);
        $doc .= $this->assembleOptions($this->options);

        return $doc;
    }

    /**
     * @param string[] $usages
     *
     * @return string
     */
    protected function assembleUsage(array $usages): string
    {
        if (empty($usages)) {
            return '';
        }

        $prepend = function (string $text): string {
            return "  $text";
        };

        $usages = array_map($prepend, $usages);

        return 'Usage:' . PHP_EOL . implode(PHP_EOL, $usages) . PHP_EOL . PHP_EOL;
    }

    /**
     * @param \Jawira\MiniGetopt\Value[] $options
     *
     * @return string
     */
    protected function assembleOptions(array $options): string
    {
        if (empty($options)) {
            return '';
        }

        $section = 'Options:' . PHP_EOL;
        $findMax = function (int $carry, Value $value): int {
            return max(mb_strlen($value->getDocNames()), $carry);
        };
        $padding = array_reduce($this->options, $findMax, 0);

        foreach ($options as $option) {
            $section .= '  ' . str_pad($option->getDocNames(), $padding) . '  ' . $option->getDescription() . PHP_EOL;
        }

        return $section . PHP_EOL;
    }

    /**
     * @param string $shortOption
     * @param string $longOption
     *
     * @throws \Jawira\MiniGetopt\MiniGetoptException
     * @return mixed
     */
    public function getOption(string $shortOption, string $longOption)
    {
        if (!Validator::isShortOrLong($shortOption, $longOption)) {
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
