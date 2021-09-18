<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Unit\AbstractUnit;
use Rikudou\Units\Unit\Length\LengthUnit;
use ZEngine\System\OpCode;

// todo handle minutes etc. not being 10 based
abstract class AbstractTimeUnit extends AbstractUnit implements TimeUnit
{
    protected static function getDefaultUnitClass(): string
    {
        return Second::class;
    }

    protected function getAllowedUnits(): array
    {
        return [
            OpCode::ADD => [
                TimeUnit::class,
            ],
            OpCode::SUB => [
                TimeUnit::class,
            ],
            OpCode::MUL => [
                // todo
                //LengthUnit::class,
            ],
        ];
    }
}
