<?php declare(strict_types=1);

namespace Jawira\MiniGetopt;

use function Jawira\TheLostFunctions\str_bytes;

/**
 * Class Validator
 *
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 * @internal
 */
abstract class Validator
{
    /**
     * Tells if $shortOption is a valid short option.
     *
     * Options can only have A-Za-z0-9.
     */
    public static function isShortOption(string $shortOption): bool
    {
        $isAlnum   = ctype_alnum($shortOption);
        $isOneChar = str_bytes($shortOption) === 1;

        return $isAlnum && $isOneChar;
    }

    /**
     * Tells if $longOption is a valid long option.
     *
     * Options can only have A-Za-z0-9.
     */
    public static function isLongOption(string $longOption): bool
    {
        $isAlnum     = ctype_alnum($longOption);
        $isManyChars = str_bytes($longOption) > 1;

        return $isAlnum && $isManyChars;
    }

    /**
     * Tells if $string is an empty string.
     */
    public static function isEmptyString(string $string): bool
    {
        return $string === Value::EMPTY_STRING;
    }

    /**
     * Tells if $string is not an empty string.
     */
    public static function isNotEmptyString(string $string): bool
    {
        return !self::isEmptyString($string);
    }

    /**
     * Tells if at least one of method arguments is valid.
     */
    public static function isShortOrLong(string $shortOption, string $longOption): bool
    {
        return self::isShortOption($shortOption) || self::isLongOption($longOption);
    }
}
