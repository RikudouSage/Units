<?php

namespace Rikudou\Units\Unit\Temperature;

use Closure;
use Rikudou\Units\Number\BigNumber;

final class Kelvin extends AbstractTemperatureUnit
{
    public function getSymbol(): string
    {
        return 'K';
    }

    protected static function getConversionToDefaultUnit(): Closure
    {
        return function (BigNumber $value): BigNumber {
            return new BigNumber($value - 273.15);
        };
    }

    protected static function getConversionFromDefaultUnit(): Closure
    {
        return function (BigNumber $value): BigNumber {
            return new BigNumber($value + 273.15);
        };
    }
}
