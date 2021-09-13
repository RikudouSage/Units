<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class CubicCentimeter extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'cm³';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1_000);
    }
}
