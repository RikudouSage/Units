<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Number\BigNumber;

final class Meter extends AbstractLengthUnit
{
    public function getSymbol(): string
    {
        return 'm';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1_000);
    }
}
