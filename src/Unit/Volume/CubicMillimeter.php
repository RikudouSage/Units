<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class CubicMillimeter extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'mm³';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1);
    }
}
