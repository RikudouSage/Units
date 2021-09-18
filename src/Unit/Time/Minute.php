<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Number\BigNumber;

final class Minute extends AbstractTimeUnit
{
    public function getSymbol(): string
    {
        return 'm';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(60);
    }
}
