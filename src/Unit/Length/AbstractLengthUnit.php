<?php

namespace Rikudou\Units\Unit\Length;

use Rikudou\Units\Converter\UnitConverter;
use Rikudou\Units\Unit\AbstractUnit;
use Rikudou\Units\Unit\Area\AreaUnit;
use Rikudou\Units\Unit\Area\SquareCentimeter;
use Rikudou\Units\Unit\Area\SquareFoot;
use Rikudou\Units\Unit\Area\SquareKilometer;
use Rikudou\Units\Unit\Area\SquareMeter;
use Rikudou\Units\Unit\Area\SquareMillimeter;
use Rikudou\Units\Unit\Unit;
use Rikudou\Units\Unit\Volume\CubicCentimeter;
use Rikudou\Units\Unit\Volume\CubicFoot;
use Rikudou\Units\Unit\Volume\CubicKilometer;
use Rikudou\Units\Unit\Volume\CubicMeter;
use Rikudou\Units\Unit\Volume\CubicMillimeter;
use RuntimeException;
use ZEngine\ClassExtension\ObjectDoOperationInterface;
use ZEngine\System\OpCode;

abstract class AbstractLengthUnit extends AbstractUnit implements LengthUnit, ObjectDoOperationInterface
{
    protected static function getDefaultUnitClass(): string
    {
        return Millimeter::class;
    }

    protected static function multiplyTwoUnits(Unit $left, Unit $right): Unit
    {
        $areBothLengthUnits = self::areBothLengthUnits($left, $right);
        if ($areBothLengthUnits) {
            $result = new SquareMillimeter($left->asDefaultUnit()->getValue() * $right->asDefaultUnit()->getValue());
        } elseif ($left instanceof AreaUnit || $right instanceof AreaUnit) {
            $value = $left->asDefaultUnit()->getValue() * $right->asDefaultUnit()->getValue();
            $result = new CubicMillimeter($value);
        } else {
            throw new RuntimeException(sprintf(
                "Unsupported multiplication between '%s' and '%s'",
                get_class($left),
                get_class($right)
            ));
        }

        $targetClass = $areBothLengthUnits ? SquareMillimeter::class : CubicMillimeter::class;
        $lengthUnit = $left instanceof LengthUnit ? $left : $right;

        switch (get_class($lengthUnit)) {
            case Centimeter::class:
                $targetClass = $areBothLengthUnits ? SquareCentimeter::class : CubicCentimeter::class;
                break;
            case Meter::class:
                $targetClass = $areBothLengthUnits ? SquareMeter::class : CubicMeter::class;
                break;
            case Kilometer::class:
                $targetClass = $areBothLengthUnits ? SquareKilometer::class : CubicKilometer::class;
                break;
            case Foot::class:
                $targetClass = $areBothLengthUnits ? SquareFoot::class : CubicFoot::class;
                break;
        }

        $converter = new UnitConverter();

        return $converter->convert($result, $targetClass);
    }

    protected static function exponentiate(Unit $left, $right): Unit
    {
        $rightValue = self::getDefaultUnitRepresentation($right);
        if ((string) $rightValue === '2') {
            $targetClass = SquareMillimeter::class;
        } elseif ((string) $rightValue === '3') {
            $targetClass = CubicMillimeter::class;
        } else {
            throw new RuntimeException(sprintf(
                'You can only exponentiate length units to the power of 2 or 3, %s given',
                (string) $rightValue
            ));
        }

        $square = (string) $rightValue === '2';

        $result = new $targetClass($left->asDefaultUnit()->getValue() ** $rightValue);

        switch (get_class($left)) {
            case Centimeter::class:
                $targetClass = $square ? SquareCentimeter::class : CubicCentimeter::class;
                break;
            case Meter::class:
                $targetClass = $square ? SquareMeter::class : CubicMeter::class;
                break;
            case Kilometer::class:
                $targetClass = $square ? SquareKilometer::class : CubicKilometer::class;
                break;
            case Foot::class:
                $targetClass = $square ? SquareFoot::class : CubicFoot::class;
                break;
        }

        $converter = new UnitConverter();

        return $converter->convert($result, $targetClass);
    }

    protected function getAllowedUnits(): array
    {
        return [
            OpCode::ADD => [
                LengthUnit::class,
            ],
            OpCode::SUB => [
                LengthUnit::class,
            ],
            OpCode::MUL => [
                LengthUnit::class,
                AreaUnit::class,
            ],
            OpCode::DIV => [],
        ];
    }

    private static function areBothLengthUnits(Unit $left, Unit $right): bool
    {
        return $left instanceof LengthUnit && $right instanceof LengthUnit;
    }
}
