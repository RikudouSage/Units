<?php

namespace Rikudou\Units\Unit\Time;

use Rikudou\Units\Converter\UnitConverter;
use Rikudou\Units\Unit\AbstractUnit;
use Rikudou\Units\Unit\Length\Kilometer;
use Rikudou\Units\Unit\Length\LengthUnit;
use Rikudou\Units\Unit\Length\Mile;
use Rikudou\Units\Unit\Speed\KilometersPerHour;
use Rikudou\Units\Unit\Speed\MetersPerSecond;
use Rikudou\Units\Unit\Speed\MilesPerHour;
use Rikudou\Units\Unit\Unit;
use ZEngine\System\OpCode;

// todo handle minutes etc. not being 10 based
abstract class AbstractTimeUnit extends AbstractUnit implements TimeUnit
{
    protected static function getDefaultUnitClass(): string
    {
        return Second::class;
    }

    protected static function multiplyTwoUnits(Unit $left, Unit $right): Unit
    {
        $converter = new UnitConverter();

        $timeUnit = $left instanceof TimeUnit ? $left : $right;
        $otherUnit = $left instanceof TimeUnit ? $right : $left;

        if ($otherUnit instanceof LengthUnit) {
            $convertedTimeUnit = $converter->convert($timeUnit, Hour::class);
            $convertedLengthUnit = $converter->convert($otherUnit, Kilometer::class);

            $result = new KilometersPerHour($convertedLengthUnit->getValue() / $convertedTimeUnit->getValue());

            switch (get_class($timeUnit)) {
                case Hour::class:
                    if (get_class($otherUnit) === Mile::class) {
                        $targetClass = MilesPerHour::class;
                    }
                    break;
                case Second::class:
                    $targetClass = MetersPerSecond::class;
                    break;
            }
        } else {
            return parent::multiplyTwoUnits($left, $right);
        }

        if (isset($targetClass)) {
            $result = $converter->convert($result, $targetClass);
        }

        return $result;
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
                LengthUnit::class,
            ],
        ];
    }
}
