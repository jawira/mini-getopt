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
    const TEMPLATE = '%s=[%s]';

    protected function getSeparator(): string
    {
        return self::OPTIONAL;
    }

    protected function getDocTemplate(): string
    {
        return self::TEMPLATE;
    }
}
