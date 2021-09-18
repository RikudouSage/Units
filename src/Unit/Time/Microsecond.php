<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Number\BigNumber;

final class Microsecond extends AbstractTimeUnit
{
    public function getSymbol(): string
    {
        return 'µs';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1e-6);
    }
}
