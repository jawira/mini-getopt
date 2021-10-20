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
    public static function isShortOption(string $shortOption): bool
    {
        $isAlnum       = ctype_alnum($shortOption);
        $isSingleChars = str_bytes($shortOption) === 1;

        return $isAlnum && $isSingleChars;
    }

    public static function isLongOption(string $longOption): bool
    {
        $isAlnum     = ctype_alnum($longOption);
        $isManyChars = str_bytes($longOption) > 1;

        return $isAlnum && $isManyChars;
    }

    public static function isEmptyString(string $string): bool
    {
        return $string === Value::EMPTY_STRING;
    }

    public static function isNotEmptyString(string $string): bool
    {
        return !self::isEmptyString($string);
    }

    public static function isShortOrLong(string $shortOption, string $longOption): bool
    {
        return self::isShortOption($shortOption) || self::isLongOption($longOption);
    }
}
