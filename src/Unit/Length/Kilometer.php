<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Number\BigNumber;

final class Kilometer extends AbstractLengthUnit
{
    public function getSymbol(): string
    {
        return 'km';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1_000_000);
    }
}
