<?php declare(strict_types=1);

namespace Jawira\MiniGetoptTests;


use Jawira\MiniGetopt\MiniGetoptException;
use Jawira\MiniGetopt\NoValue;
use PHPUnit\Framework\TestCase;

class NoValueTest extends TestCase
{
    /**
     * Tests for NoValue::getShortOption.
     *
     * @covers       \Jawira\MiniGetopt\NoValue::getShortOption
     * @covers       \Jawira\MiniGetopt\NoValue::__construct
     * @covers       \Jawira\MiniGetopt\NoValue::getSeparator
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @testdox Short option $shortOption becomes $expected in getopt()
     * @dataProvider getShortOptionProvider
     */
    public function testGetShortOption($shortOption = 'x', $expected = 'x')
    {
        $noValue = new NoValue($shortOption, '');
        $actual  = $noValue->getShortOption();

        $this->assertSame($expected, $actual);
    }

    public function getShortOptionProvider(): array
    {
        return [
            ['x', 'x'],
            ['A', 'A'],
            ['1', '1'],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\NoValue::getLongOption()
     * @covers       \Jawira\MiniGetopt\NoValue::__construct
     * @covers       \Jawira\MiniGetopt\NoValue::getSeparator
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @testdox Long option $longOption becomes $expected in getopt()
     * @dataProvider getLongOptionProvider
     */
    public function testGetLongOption($longOption = 'help', $expected = 'help')
    {
        $noValue = new NoValue('', $longOption);
        $actual  = $noValue->getLongOption();

        $this->assertSame($expected, $actual);
    }

    public function getLongOptionProvider(): array
    {
        return [
            ['help', 'help'],
            ['HELP', 'HELP'],
            ['007', '007'],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\NoValue::getDescription
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @covers       \Jawira\MiniGetopt\NoValue::__construct
     * @dataProvider getDescriptionProvider
     * @testdox Description $description becomes $expected in getopt()
     */
    public function testGetDescription($description = 'hello', $expected = 'hello')
    {
        $noValue = new NoValue('d', 'dummy', $description);
        $actual  = $noValue->getDescription();

        $this->assertSame($expected, $actual);
    }

    public function getDescriptionProvider()
    {
        return [
            ['', ''],
            ['Hello world', 'Hello world'],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\NoValue::getDocNames()
     * @covers       \Jawira\MiniGetopt\NoValue::__construct
     * @covers       \Jawira\MiniGetopt\NoValue::getDocTemplate
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @testdox Options $shortName and $longName are displayed as $expected
     * @dataProvider getDocNamesProvider
     */
    public function testGetDocNames($shortName = 'd', $longName = 'dummy', $description = '', $expected = '-d --dummy')
    {
        $noValue = new NoValue($shortName, $longName, $description);
        $actual  = $noValue->getDocNames();

        $this->assertSame($expected, $actual);
    }

    public function getDocNamesProvider()
    {
        return [
            ['h', 'help', '', '-h --help'],
            ['h', '', '', '-h'],
            ['', 'help', '', '--help'],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\NoValue::__construct
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @testdox Short option $shortOption is invalid
     * @dataProvider invalidShortOptionProvider
     */
    public function testInvalidShortOption($shortOption)
    {
        $this->expectException(MiniGetoptException::class);
        $this->expectExceptionMessage('Invalid short option');

        new NoValue($shortOption);
    }

    public function invalidShortOptionProvider(): array
    {
        return [
            [','],
            ['dummy'],
            [':'],
            ['('],
            ['è'],
            ['55'],
            ['%'],
            ['£'],
            [' '],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\NoValue::__construct
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @testdox Long option $longOption is invalid
     * @dataProvider invalidLongOptionProvider
     */
    public function testInvalidLongOption($longOption)
    {
        $this->expectException(MiniGetoptException::class);
        $this->expectExceptionMessage('Invalid long option');

        new NoValue('', $longOption);
    }

    public function invalidLongOptionProvider(): array
    {
        return [
            ['a'],
            [';'],
            [';;;;'],
            ['qsdfùqdsf'],
            [',hello'],
            ['hello?'],
            ['@@'],
            ['<qsdf'],
        ];
    }


    /**
     * @covers \Jawira\MiniGetopt\NoValue::__construct
     * @covers \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers \Jawira\MiniGetopt\Validator::isShortOption
     * @covers \Jawira\MiniGetopt\Validator::isLongOption
     * @covers \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers \Jawira\MiniGetopt\Value::__construct
     * @testdox No short nor long option provided
     */
    public function testInvalidLongOrShortOption()
    {
        $this->expectException(MiniGetoptException::class);
        $this->expectExceptionMessage('You should define at least short option or long option');

        new NoValue();
    }
}
