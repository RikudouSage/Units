<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Number\BigNumber;

final class Inch extends AbstractLengthUnit
{
    public function __toString(): string
    {
        return "{$this->value}″";
    }

    public function getSymbol(): string
    {
        return 'in';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(25.4);
    }
}
