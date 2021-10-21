<?php declare(strict_types=1);

namespace Jawira\MiniGetopt;

/**
 * Class OptionalValue
 *
 * @internal
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
class OptionalValue extends Value
{
    protected function getSeparator(): string
    {
        return '::';
    }

    protected function getDocTemplate(): string
    {
        return '%s=[%s]';
    }
}
