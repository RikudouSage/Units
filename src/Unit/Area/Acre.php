<?php

namespace Rikudou\Units\Unit\Area;

use Rikudou\Units\Number\BigNumber;

final class Acre extends AbstractAreaUnit
{
    public function getSymbol(): string
    {
        return 'acre';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(4_046_856_422.4);
    }
}
