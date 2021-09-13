<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Number\BigNumber;

final class Centimeter extends AbstractLengthUnit
{
    public function getSymbol(): string
    {
        return 'cm';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(10);
    }
}
