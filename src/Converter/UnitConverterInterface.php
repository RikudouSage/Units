<?php

namespace Rikudou\Units\Converter;

use Rikudou\Units\Unit\Unit;

interface UnitConverterInterface
{
    public function convert(Unit $unit, string $targetClass): Unit;
}
