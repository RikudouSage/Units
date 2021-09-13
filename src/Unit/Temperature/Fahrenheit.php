<?php

namespace Rikudou\Units\Unit\Temperature;

use Closure;
use Rikudou\Units\Number\BigNumber;

final class Fahrenheit extends AbstractTemperatureUnit
{
    public function getSymbol(): string
    {
        return '°F';
    }

    protected static function getConversionToDefaultUnit(): Closure
    {
        return function (BigNumber $value): BigNumber {
            return new BigNumber((($value - 32) * 5) / 9);
        };
    }

    protected static function getConversionFromDefaultUnit(): Closure
    {
        return function (BigNumber $value): BigNumber {
            return new BigNumber(new BigNumber(1.8) * $value + 32);
        };
    }
}
