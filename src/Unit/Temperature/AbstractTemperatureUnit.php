<?php

namespace Rikudou\Units\Unit\Temperature;

use Rikudou\Units\Unit\AbstractUnit;
use ZEngine\System\OpCode;

abstract class AbstractTemperatureUnit extends AbstractUnit implements TemperatureUnit
{
    protected static function getDefaultUnitClass(): string
    {
        return Celsius::class;
    }

    protected function getAllowedUnits(): array
    {
        return [
            OpCode::ADD => [
                TemperatureUnit::class,
            ],
            OpCode::SUB => [
                TemperatureUnit::class,
            ],
        ];
    }
}
