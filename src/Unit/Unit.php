<?php

namespace Rikudou\Units\Unit;

use Rikudou\Units\Number\BigNumber;

interface Unit
{
    public function getValue(): BigNumber;

    public function asDefaultUnit(): Unit;

    public static function fromDefaultUnit(Unit $from): Unit;

    public function getSymbol(): string;
}
