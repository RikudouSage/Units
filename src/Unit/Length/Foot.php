<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Converter\UnitConverter;
use Rikudou\Units\Number\BigNumber;

final class Foot extends AbstractLengthUnit
{
    public function __toString(): string
    {
        $converter = new UnitConverter();

        $withoutDecimals = new self((int) $this->value);
        $inchesTotal = $converter->convert($this, Inch::class);
        $inchesWithoutDecimals = $converter->convert($withoutDecimals, Inch::class);
        $remaining = $inchesTotal - $inchesWithoutDecimals;

        if (!$remaining->getValue()) {
            $remaining = '';
        }

        return "{$withoutDecimals->value}′{$remaining}";
    }

    public function getSymbol(): string
    {
        return 'ft';
    }

    protected static function getConversionToDefaultUnit(): BigNumber
    {
        return new BigNumber(304.8);
    }
}
