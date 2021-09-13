<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class CubicKilometer extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'km³';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber((int) 1e18);
    }
}
