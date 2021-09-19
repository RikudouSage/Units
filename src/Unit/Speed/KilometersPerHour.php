<?php

namespace Rikudou\Units\Unit\Speed;

use Rikudou\Units\Number\BigNumber;

final class KilometersPerHour extends AbstractSpeedUnit
{
    public function getSymbol(): string
    {
        return 'km/h';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1);
    }
}
