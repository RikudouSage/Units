<?php

namespace Rikudou\Units\Unit\Area;

use Rikudou\Units\Number\BigNumber;

final class SquareMillimeter extends AbstractAreaUnit
{
    public function getSymbol(): string
    {
        return 'mm²';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1);
    }
}
