<?php

namespace Rikudou\Units\Unit\Volume;

use Rikudou\Units\Converter\UnitConverter;
use Rikudou\Units\Unit\AbstractUnit;
use Rikudou\Units\Unit\Area\AreaUnit;
use Rikudou\Units\Unit\Area\SquareCentimeter;
use Rikudou\Units\Unit\Area\SquareMeter;
use Rikudou\Units\Unit\Area\SquareMillimeter;
use Rikudou\Units\Unit\Length\Centimeter;
use Rikudou\Units\Unit\Length\LengthUnit;
use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Millimeter;
use Rikudou\Units\Unit\Unit;
use ZEngine\System\OpCode;

abstract class AbstractVolumeUnit extends AbstractUnit implements VolumeUnit
{
    protected static function getDefaultUnitClass(): string
    {
        return CubicMillimeter::class;
    }

    protected static function divideTwoUnits(Unit $left, Unit $right): Unit
    {
        if (!$left instanceof VolumeUnit || (!$right instanceof AreaUnit && !$right instanceof LengthUnit)) {
            return parent::divideTwoUnits($left, $right);
        }

        $wantLengthResult = $right instanceof AreaUnit;

        $value = $left->asDefaultUnit()->getValue() / $right->asDefaultUnit()->getValue();
        if ($wantLengthResult) {
            $result = new Millimeter($value);
        } else {
            $result = new SquareMillimeter($value);
        }

        $targetClass = $wantLengthResult ? Millimeter::class : SquareMillimeter::class;
        switch (get_class($left)) {
            case CubicCentimeter::class:
                $targetClass = $wantLengthResult ? Centimeter::class : SquareCentimeter::class;
                break;
            case CubicMeter::class:
                $targetClass = $wantLengthResult ? Meter::class : SquareMeter::class;
                break;
        }

        $converter = new UnitConverter();

        return $converter->convert($result, $targetClass);
    }

    protected function getAllowedUnits(): array
    {
        return [
            OpCode::ADD => [
                VolumeUnit::class,
            ],
            OpCode::SUB => [
                VolumeUnit::class,
            ],
            OpCode::MUL => [],
            OpCode::DIV => [
                AreaUnit::class,
                LengthUnit::class,
            ],
        ];
    }
}
