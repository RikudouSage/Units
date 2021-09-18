<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class Millilitre extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'ml';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1_000);
    }
}
