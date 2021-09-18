<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class Litre extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'l';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1e6);
    }
}
