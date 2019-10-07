<?php

namespace Jawira\MiniGetopt;

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
