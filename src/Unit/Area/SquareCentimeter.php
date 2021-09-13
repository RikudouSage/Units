<?php

namespace Rikudou\Units\Unit\Area;

use Rikudou\Units\Number\BigNumber;

final class SquareCentimeter extends AbstractAreaUnit
{
    public function getSymbol(): string
    {
        return 'cm²';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(100);
    }
}
