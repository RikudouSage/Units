<?php

namespace Rikudou\Units\Unit\Area;

use Rikudou\Units\Number\BigNumber;

final class SquareMeter extends AbstractAreaUnit
{
    public function getSymbol(): string
    {
        return 'm²';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1_000_000);
    }
}
