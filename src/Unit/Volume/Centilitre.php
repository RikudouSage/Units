<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class Centilitre extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'cl';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(10_000);
    }
}
