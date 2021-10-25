<?php declare(strict_types=1);

namespace Jawira\MiniGetopt;

/**
 * @internal
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
class NoValue extends Value
{
    public function __construct(string $shortOption = self::EMPTY_STRING,
                                string $longOption = self::EMPTY_STRING,
                                string $description = self::EMPTY_STRING)
    {
        parent::__construct($shortOption, $longOption, $description, self::EMPTY_STRING);
    }

    protected function getSeparator(): string
    {
        return '';
    }

    protected function getDocTemplate(): string
    {
        return '%s%s';
    }
}
