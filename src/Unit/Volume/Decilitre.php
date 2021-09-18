<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class Decilitre extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'dl';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(100_000);
    }
}
