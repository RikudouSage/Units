<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class CubicMeter extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'm³';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber((int) 1e9);
    }
}
