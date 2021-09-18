<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Number\BigNumber;

final class Millisecond extends AbstractTimeUnit
{
    public function getSymbol(): string
    {
        return 'ms';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(0.001);
    }
}
