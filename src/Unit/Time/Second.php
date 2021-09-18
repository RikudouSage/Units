<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Number\BigNumber;

final class Second extends AbstractTimeUnit
{
    public function getSymbol(): string
    {
        return 's';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1);
    }
}
