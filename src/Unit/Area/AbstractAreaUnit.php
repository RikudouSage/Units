<?php

namespace Rikudou\Units\Unit\Area;

use Rikudou\Units\Converter\UnitConverter;
use Rikudou\Units\Unit\AbstractUnit;
use Rikudou\Units\Unit\Length\Centimeter;
use Rikudou\Units\Unit\Length\Kilometer;
use Rikudou\Units\Unit\Length\LengthUnit;
use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Millimeter;
use Rikudou\Units\Unit\Unit;
use RuntimeException;
use ZEngine\System\OpCode;

abstract class AbstractAreaUnit extends AbstractUnit implements AreaUnit
{
    protected static function getDefaultUnitClass(): string
    {
        return SquareMillimeter::class;
    }

    protected static function multiplyTwoUnits(Unit $left, Unit $right): Unit
    {
        if (
            !($left instanceof LengthUnit && $right instanceof AreaUnit)
            && !($left instanceof AreaUnit && $right instanceof LengthUnit)
        ) {
            throw new RuntimeException(sprintf(
                "Unsupported multiplication between '%s' and '%s'. You can only multiply between area and length.",
                get_class($left),
                get_class($right)
            ));
        }

        $lengthUnit = $left instanceof LengthUnit ? $left : $right;
        $other = $left === $lengthUnit ? $right : $left;

        return $lengthUnit * $other;
    }

    protected static function divideTwoUnits(Unit $left, Unit $right): Unit
    {
        if (!$left instanceof AreaUnit || !$right instanceof LengthUnit) {
            throw new RuntimeException(sprintf(
                "Cannot divide '%s' by '%s'. You can only divide area by a length unit.",
                get_class($left),
                get_class($right)
            ));
        }

        $targetClass = Millimeter::class;
        $result = new Millimeter($left->asDefaultUnit()->getValue() / $right->asDefaultUnit()->getValue());

        switch (get_class($left)) {
            case SquareCentimeter::class:
                $targetClass = Centimeter::class;
                break;
            case SquareKilometer::class:
                $targetClass = Kilometer::class;
                break;
            case SquareMeter::class:
                $targetClass = Meter::class;
                break;
        }

        $converter = new UnitConverter();

        return $converter->convert($result, $targetClass);
    }

    protected function getAllowedUnits(): array
    {
        return [
            OpCode::ADD => [
                AreaUnit::class,
            ],
            OpCode::SUB => [
                AreaUnit::class,
            ],
            OpCode::MUL => [
                LengthUnit::class,
            ],
            OpCode::DIV => [
                LengthUnit::class,
            ],
        ];
    }
}
