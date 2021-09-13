<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Number\BigNumber;

final class CubicFoot extends AbstractVolumeUnit
{
    public function getSymbol(): string
    {
        return 'cu. ft.';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(28_316_846.6);
    }
}
