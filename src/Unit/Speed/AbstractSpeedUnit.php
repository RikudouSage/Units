<?php

namespace Rikudou\Units\Unit\Speed;

use Rikudou\Units\Unit\AbstractUnit;
use ZEngine\System\OpCode;

abstract class AbstractSpeedUnit extends AbstractUnit implements SpeedUnit
{
    protected static function getDefaultUnitClass(): string
    {
        return KilometersPerHour::class;
    }

    protected function getAllowedUnits(): array
    {
        return [
            OpCode::ADD => [
                SpeedUnit::class,
            ],
            OpCode::SUB => [
                SpeedUnit::class,
            ],
        ];
    }
}
