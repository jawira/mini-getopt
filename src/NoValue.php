<?php

namespace Jawira\MiniGetopt;

/**
 * Class NoValue
 *
 * @internal
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
class NoValue extends Value
{
    const TEMPLATE = <<<TEMPLATE
%s %s
%s

TEMPLATE;

    public function __construct(?string $shortOption, ?string $longOption, string $description = self::EMPTY)
    {
        parent::__construct($shortOption, $longOption, $description, self::EMPTY);
    }

    protected function getSeparator(): string
    {
        return self::NO_VALUE;
    }

    protected function getDocTemplate(): string
    {
        return self::TEMPLATE;
    }
}

