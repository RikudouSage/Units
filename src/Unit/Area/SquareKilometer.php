<?php

namespace Rikudou\Units\Unit\Area;

use Rikudou\Units\Number\BigNumber;

final class SquareKilometer extends AbstractAreaUnit
{
    public function getSymbol(): string
    {
        return 'km²';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber((int) 1e12);
    }
}
