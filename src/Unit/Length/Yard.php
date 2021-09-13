<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Number\BigNumber;

final class Yard extends AbstractLengthUnit
{
    public function getSymbol(): string
    {
        return 'yd';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(914.4);
    }
}
