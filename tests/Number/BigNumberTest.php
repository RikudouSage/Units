<?php

namespace Rikudou\Tests\Units\Number;

use PHPUnit\Framework\TestCase;
use Rikudou\Units\Exception\InvalidNumberException;
use Rikudou\Units\Number\BigNumber;
use stdClass;

final class BigNumberTest extends TestCase
{
    public function testConstruct()
    {
        $int = new BigNumber(5);
        self::assertEquals('5', (string) $int);
        $float = new BigNumber(5.5);
        self::assertEquals('5.5', (string) $float);
        $string = new BigNumber('100');
        self::assertEquals('100', (string) $string);
        $bigNumber = new BigNumber(new BigNumber(5));
        self::assertEquals('5', (string) $bigNumber);
        $object = new BigNumber(new class {
            public function __toString()
            {
                return '15';
            }
        });
        self::assertEquals('15', (string) $object);

        // float shenanigans
        setlocale(LC_ALL, 'cs_CZ');
        if ((string) 5.5 !== '5.5') {
            // if we don't get into this section, the underlying system doesn't support the locale and the test is pointless
            $float = new BigNumber(5.5);
            self::assertEquals('5.5', (string) $float);
        }
    }

    /**
     * @dataProvider constructorInvalidValues
     */
    public function testConstructorInvalidValues($value)
    {
        $this->expectException(InvalidNumberException::class);
        new BigNumber($value);
    }

    public function testCasting()
    {
        $bigNumbers = [
            new BigNumber('5'),
            new BigNumber('-5'),
            new BigNumber(PHP_INT_MAX) + 1,
            new BigNumber(PHP_INT_MAX) * 5,
            new BigNumber('5.5'),
            new BigNumber('-5.5'),
            new BigNumber(0),
        ];

        foreach ($bigNumbers as $bigNumber) {
            self::assertInstanceOf(BigNumber::class, $bigNumber);
        }

        // string
        self::assertEquals('5', (string) $bigNumbers[0]);
        self::assertEquals('-5', (string) $bigNumbers[1]);
        self::assertEquals(PHP_INT_MAX === 2147483647 ? '2147483648' : '9223372036854775808', (string) $bigNumbers[2]);
        self::assertEquals(PHP_INT_MAX === 2147483647 ? '10737418235' : '46116860184273879035', (string) $bigNumbers[3]);
        self::assertEquals('5.5', (string) $bigNumbers[4]);
        self::assertEquals('-5.5', (string) $bigNumbers[5]);
        self::assertEquals('0', (string) $bigNumbers[6]);

        // int
        self::assertEquals(5, (int) $bigNumbers[0]);
        self::assertEquals(-5, (int) $bigNumbers[1]);
        self::assertEquals(PHP_INT_MAX, (int) $bigNumbers[2]);
        self::assertEquals(PHP_INT_MAX, (int) $bigNumbers[3]);
        self::assertEquals(5, (int) $bigNumbers[4]);
        self::assertEquals(-5, (int) $bigNumbers[5]);
        self::assertEquals(0, (int) $bigNumbers[6]);

        // bool
        self::assertTrue((bool) $bigNumbers[0]);
        self::assertTrue((bool) $bigNumbers[1]);
        self::assertTrue((bool) $bigNumbers[2]);
        self::assertTrue((bool) $bigNumbers[3]);
        self::assertTrue((bool) $bigNumbers[4]);
        self::assertTrue((bool) $bigNumbers[5]);
        self::assertFalse((bool) $bigNumbers[6]);

        // float
        self::assertEquals(5, (float) $bigNumbers[0]);
        self::assertEquals(-5, (float) $bigNumbers[1]);
        self::assertEquals(PHP_INT_MAX === 2147483647 ? 2147483648 : 9223372036854775808, (float) $bigNumbers[2]);
        self::assertEquals(PHP_INT_MAX === 2147483647 ? 10737418235 : 46116860184273879035, (float) $bigNumbers[3]);
        self::assertEquals(5.5, (float) $bigNumbers[4]);
        self::assertEquals(-5.5, (float) $bigNumbers[5]);
        self::assertEquals(0, (float) $bigNumbers[6]);
    }

    public function testComparison()
    {
        $number1 = new BigNumber(5);
        $number2 = new BigNumber(6);
        $number3 = new BigNumber(-5);
        $number4 = new BigNumber(0);
        $number5 = new BigNumber(5);

        self::assertTrue($number1 < $number2);
        self::assertTrue($number2 > $number1);
        self::assertTrue($number1 > $number3);
        self::assertTrue($number1 > $number4);
        self::assertTrue($number4 > $number3);
        self::assertTrue($number1 == $number5);
        self::assertEquals(-1, $number1 <=> $number2);
        self::assertEquals(1, $number1 <=> $number3);
        self::assertEquals(1, $number1 <=> $number4);
        self::assertEquals(0, $number1 <=> $number5);
    }

    public function constructorInvalidValues(): array
    {
        return [
            [[]],
            [new stdClass()],
            [fopen('php://memory', 'r')],
            [false],
        ];
    }
}
