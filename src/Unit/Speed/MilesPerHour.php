<?php

namespace Rikudou\Units\Unit\Speed;

use Rikudou\Units\Number\BigNumber;

final class MilesPerHour extends AbstractSpeedUnit
{
    public function getSymbol(): string
    {
        return 'mph';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1.609_344);
    }
}
