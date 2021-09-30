<?php declare(strict_types=1);

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
    const TEMPLATE = '%s%s';

    public function __construct(string $shortOption, string $longOption, string $description = self::EMPTY_STRING)
    {
        parent::__construct($shortOption, $longOption, $description, self::EMPTY_STRING);
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
