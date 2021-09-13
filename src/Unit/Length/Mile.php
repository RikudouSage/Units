<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Number\BigNumber;

final class Mile extends AbstractLengthUnit
{
    public function getSymbol(): string
    {
        return 'mi';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(1_609_344);
    }
}
