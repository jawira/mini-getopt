<?php

namespace Jawira\MiniGetopt;

class RequiredValue extends Value
{
    const TEMPLATE = <<<TEMPLATE
%s=<%s>
%s

TEMPLATE;

    protected function getSeparator(): string
    {
        return self::REQUIRED;
    }

    protected function getDocTemplate(): string
    {
        return self::TEMPLATE;
    }
}
