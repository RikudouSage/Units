<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Number\BigNumber;

final class Hour extends AbstractTimeUnit
{
    public function getSymbol(): string
    {
        return 'h';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(3_600);
    }
}
