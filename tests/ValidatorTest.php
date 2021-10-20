<?php declare(strict_types=1);

namespace Jawira\MiniGetoptTests;

use Jawira\MiniGetopt\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    /**
     * @covers  \Jawira\MiniGetopt\Validator::isEmptyString
     * @testdox The value "$value" is empty string
     */
    function testIsEmptyString()
    {
        $this->assertTrue(Validator::isEmptyString(''));
    }

    /**
     * @dataProvider isNotEmptyStringProvider
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @testdox      The value "$value" is not empty string
     */
    function testIsNotEmptyString($value)
    {
        $this->assertTrue(Validator::isNotEmptyString($value));
    }

    function isNotEmptyStringProvider()
    {
        return [
            [' '],
            ['yes'],
            ['0'],
            ["\t"],
            ["\n"],
        ];
    }

    /**
     * @dataProvider isShortOptionProvider
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @testdox      The value "$value" is a short option
     */
    function testIsShortOption($value, $expected)
    {
        $result = Validator::isShortOption($value);
        $this->assertIsBool($result);
        $this->assertSame($result, $expected);
    }

    public function isShortOptionProvider()
    {
        return [
            ['A', true],
            ['u', true],
            ['0', true],
            ['5', true],
            [' ', false],
            ['ù', false],
            ['µ', false],
            ['Σ', false],
            ['ص', false],
            ["\t", false],
            ["\n", false],
            ['', false],
            ['  ', false],
            ['xxx', false],
        ];
    }

    /**
     * @dataProvider isLongOptionProvider
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @testdox      The value "$value" is a long option
     */
    function testIsLongOption($value, $expected)
    {
        $result = Validator::isLongOption($value);
        $this->assertIsBool($result);
        $this->assertSame($result, $expected);
    }

    public function isLongOptionProvider()
    {
        return [
            [' ', false],
            ['x', false],
            ['ù', false],
            ['µ', false],
            ['u', false],
            ['u', false],
            ['0', false],
            ['Σ', false],
            ['ص', false],
            ["\t", false],
            ["\n", false],
            ['', false],
            ['  ', false],
            ['xxx', true],
            ['12', true],
            ['hello', true],
        ];
    }

    /**
     * @dataProvider isShortOrLongProvider
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @testdox      At least one of "$short" or "$long" is a valid option
     */
    function testIsShortOrLong($short, $long, $expected)
    {
        $result = Validator::isShortOrLong($short, $long);
        $this->assertIsBool($result);
        $this->assertSame($result, $expected);
    }

    public function isShortOrLongProvider()
    {
        return [
            ['a', 'qsdf', true],
            ['a', '', true],
            ['5', '', true],
            ['5', 'qsdfqsdf', true],
            ['', 'qsdfqsdf', true],
            ['X', 'sssss', true],
            ['', 'help', true],
            ['h', 'help', true],
            ['y', 'yes', true],
            ['', '456', true],
            ['', '', false],
            ['', 'Σ', false],
            ['Σ', '', false],
            ['', 'ص', false],
        ];
    }
}
