<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Number\BigNumber;

final class Millimeter extends AbstractLengthUnit
{
    public function getSymbol(): string
    {
        return 'mm';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1);
    }
}
