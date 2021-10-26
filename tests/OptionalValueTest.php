<?php declare(strict_types=1);

namespace Jawira\MiniGetoptTests;


use Jawira\MiniGetopt\MiniGetoptException;
use Jawira\MiniGetopt\NoValue;
use Jawira\MiniGetopt\OptionalValue;
use PHPUnit\Framework\TestCase;

class OptionalValueTest extends TestCase
{
    /**
     * @covers       \Jawira\MiniGetopt\OptionalValue::getShortOption
     * @covers       \Jawira\MiniGetopt\OptionalValue::getSeparator
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @testdox Short option $shortOption becomes $expected in getopt()
     * @dataProvider getShortOptionProvider
     */
    public function testGetShortOption($shortOption, $expected)
    {
        $noValue = new OptionalValue($shortOption, '');
        $actual  = $noValue->getShortOption();

        $this->assertSame($expected, $actual);
    }

    public function getShortOptionProvider(): array
    {
        return [
            ['x', 'x::'],
            ['A', 'A::'],
            ['1', '1::'],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\OptionalValue::getLongOption
     * @covers       \Jawira\MiniGetopt\OptionalValue::getSeparator
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @testdox Long option $longOption becomes $expected in getopt()
     * @dataProvider getLongOptionProvider
     */
    public function testGetLongOption($longOption, $expected)
    {
        $noValue = new OptionalValue('', $longOption);
        $actual  = $noValue->getLongOption();

        $this->assertSame($expected, $actual);
    }

    public function getLongOptionProvider(): array
    {
        return [
            ['help', 'help::'],
            ['HELP', 'HELP::'],
            ['007', '007::'],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\OptionalValue::getDescription
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isShortOrLong
     * @covers       \Jawira\MiniGetopt\Value::__construct
     * @dataProvider getDescriptionProvider
     * @testdox Description $description becomes $expected in getopt()
     */
    public function testGetDescription($description = 'hello', $expected = 'hello')
    {
        $noValue = new OptionalValue('d', 'dummy', $description);
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
     * @covers       \Jawira\MiniGetopt\OptionalValue::getDocNames()
     * @covers       \Jawira\MiniGetopt\OptionalValue::getDocTemplate
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
        $noValue = new OptionalValue($shortName, $longName, $description);
        $actual  = $noValue->getDocNames();

        $this->assertSame($expected, $actual);
    }

    public function getDocNamesProvider()
    {
        return [
            ['h', 'help', '', '-h --help=[value]'],
            ['h', '', '', '-h=[value]'],
            ['', 'help', '', '--help=[value]'],
        ];
    }

    /**
     * @covers       \Jawira\MiniGetopt\OptionalValue::__construct
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @testdox Short option $shortOption is invalid
     * @dataProvider invalidShortOptionProvider
     */
    public function testInvalidShortOption($shortOption)
    {
        $this->expectException(MiniGetoptException::class);
        $this->expectExceptionMessage('Invalid short option');

        new OptionalValue($shortOption);
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
     * @covers       \Jawira\MiniGetopt\OptionalValue::__construct
     * @covers       \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers       \Jawira\MiniGetopt\Validator::isShortOption
     * @covers       \Jawira\MiniGetopt\Validator::isLongOption
     * @testdox Long option $longOption is invalid
     * @dataProvider invalidLongOptionProvider
     */
    public function testInvalidLongOption($longOption)
    {
        $this->expectException(MiniGetoptException::class);
        $this->expectExceptionMessage('Invalid long option');

        new OptionalValue('', $longOption);
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
     * @covers \Jawira\MiniGetopt\OptionalValue::__construct
     * @covers \Jawira\MiniGetopt\Validator::isEmptyString
     * @covers \Jawira\MiniGetopt\Validator::isLongOption
     * @covers \Jawira\MiniGetopt\Validator::isNotEmptyString
     * @covers \Jawira\MiniGetopt\Validator::isShortOption
     * @covers \Jawira\MiniGetopt\Validator::isShortOrLong
     * @testdox No short nor long option provided
     */
    public function testInvalidLongOrShortOption()
    {
        $this->expectException(MiniGetoptException::class);
        $this->expectExceptionMessage('You should define at least short option or long option');

        new OptionalValue();
    }
}
