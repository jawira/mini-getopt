<?php declare(strict_types=1);

namespace Jawira\MiniGetopt;

/**
 * Class RequiredValue
 *
 * @internal
 * @author  Jawira Portugal <dev@tugal.be>
 * @package Jawira\MiniGetopt
 */
class RequiredValue extends Value
{
    const TEMPLATE = '%s=<%s>';

    protected function getSeparator(): string
    {
        return self::REQUIRED;
    }

    protected function getDocTemplate(): string
    {
        return self::TEMPLATE;
    }
}
