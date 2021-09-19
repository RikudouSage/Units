<?php

namespace Rikudou\Units\Unit\Speed;

use Rikudou\Units\Number\BigNumber;

final class MetersPerSecond extends AbstractSpeedUnit
{
    public function getSymbol(): string
    {
        return 'm/s';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(3.6);
    }
}
