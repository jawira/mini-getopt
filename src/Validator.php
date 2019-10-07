<?php

namespace Jawira\MiniGetopt;

class Validator
{

    /**
     * Validates short option
     *
     * @param string $shortOption
     *
     * @return bool
     */
    public function isShortOption(?string $shortOption): bool
    {
        if (is_null($shortOption)) {
            return true;
        }

        return mb_strlen($shortOption) === 1;
    }

    /**
     * Validates long option
     *
     * @param string $longOption
     *
     * @return bool
     */
    public function isLongOption(?string $longOption): bool
    {
        if (is_null($longOption)) {
            return true;
        }

        return mb_strlen($longOption) > 1;
    }

    public function isEmptyString(?string $string): bool
    {
        $string = is_null($string) ? '' : $string;

        return mb_strlen($string) === 0;
    }

    public function isNotEmptyString(string $string): bool
    {
        return !$this->isEmptyString($string);
    }

    public function validateShortAndLong(?string $shortOption, ?string $longOption): self
    {
        if (!$this->isShortOption($shortOption)) {
            throw new MiniGetoptException("Short option '$shortOption' should be one character long");
        }
        if (!$this->isLongOption($longOption)) {
            throw new MiniGetoptException("Long option '$longOption' should be at least two characters long");
        }
        if ($this->isEmptyString($shortOption) && $this->isEmptyString($longOption)) {
            throw new MiniGetoptException("You should define at least short option or long option");
        }

        return $this;
    }
}
