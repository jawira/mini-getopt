<?php

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
    const TEMPLATE = <<<TEMPLATE
%s=[%s]
%s

TEMPLATE;

    protected function getSeparator(): string
    {
        return self::OPTIONAL;
    }

    protected function getDocTemplate(): string
    {
        return self::TEMPLATE;
    }
}
