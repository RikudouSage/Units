<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Number\BigNumber;

final class Day extends AbstractTimeUnit
{
    public function getSymbol(): string
    {
        return 'd';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(86_400);
    }
}
