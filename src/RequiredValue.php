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
    protected function getSeparator(): string
    {
        return ':';
    }

    protected function getDocTemplate(): string
    {
        return '%s=<%s>';
    }
}
