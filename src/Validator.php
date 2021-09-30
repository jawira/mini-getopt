<?php declare(strict_types=1);

namespace Jawira\MiniGetopt;

use function mb_strlen;

/**
 * Class Validator
 *
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
class Validator
{
    public function isShortOption(string $shortOption): bool
    {
        return mb_strlen($shortOption) === 1;
    }

    public function isLongOption(string $longOption): bool
    {
        return mb_strlen($longOption) > 1;
    }

    public function isEmptyString(string $string): bool
    {
        return mb_strlen($string) === 0;
    }

    public function isNotEmptyString(string $string): bool
    {
        return !$this->isEmptyString($string);
    }

    /**
     * @param string $shortOption
     * @param string $longOption
     *
     * @return bool
     */
    public function isShortOrLong(string $shortOption, string $longOption): bool
    {
        return $this->isShortOption($shortOption) || $this->isLongOption($longOption);
    }
}
