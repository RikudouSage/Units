<?php

namespace Rikudou\Units\Unit\Temperature;

use Rikudou\Units\Number\BigNumber;

final class Celsius extends AbstractTemperatureUnit
{
    public function getSymbol(): string
    {
        return '°C';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1);
    }
}
