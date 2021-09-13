<?php

namespace Rikudou\Units\Unit\Area;

use Rikudou\Units\Number\BigNumber;

final class SquareFoot extends AbstractAreaUnit
{
    public function getSymbol(): string
    {
        return 'sq. ft.';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber('92903.04');
    }
}
