<?php

use Rikudou\Units\Number\BigNumber;
use Rikudou\Units\Unit\Area\Acre;
use Rikudou\Units\Unit\Area\SquareCentimeter;
use Rikudou\Units\Unit\Area\SquareFoot;
use Rikudou\Units\Unit\Area\SquareKilometer;
use Rikudou\Units\Unit\Area\SquareMeter;
use Rikudou\Units\Unit\Area\SquareMillimeter;
use Rikudou\Units\Unit\Length\Centimeter;
use Rikudou\Units\Unit\Length\Foot;
use Rikudou\Units\Unit\Length\Inch;
use Rikudou\Units\Unit\Length\Kilometer;
use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Mile;
use Rikudou\Units\Unit\Length\Millimeter;
use Rikudou\Units\Unit\Length\Yard;
use Rikudou\Units\Unit\Speed\KilometersPerHour;
use Rikudou\Units\Unit\Speed\MetersPerSecond;
use Rikudou\Units\Unit\Speed\MilesPerHour;
use Rikudou\Units\Unit\Temperature\Celsius;
use Rikudou\Units\Unit\Temperature\Fahrenheit;
use Rikudou\Units\Unit\Temperature\Kelvin;
use Rikudou\Units\Unit\Time\Day;
use Rikudou\Units\Unit\Time\Hour;
use Rikudou\Units\Unit\Time\Microsecond;
use Rikudou\Units\Unit\Time\Millisecond;
use Rikudou\Units\Unit\Time\Minute;
use Rikudou\Units\Unit\Time\Second;
use Rikudou\Units\Unit\Volume\Centilitre;
use Rikudou\Units\Unit\Volume\CubicCentimeter;
use Rikudou\Units\Unit\Volume\CubicFoot;
use Rikudou\Units\Unit\Volume\CubicKilometer;
use Rikudou\Units\Unit\Volume\CubicMeter;
use Rikudou\Units\Unit\Volume\CubicMillimeter;
use Rikudou\Units\Unit\Volume\Decilitre;
use Rikudou\Units\Unit\Volume\Litre;
use Rikudou\Units\Unit\Volume\Millilitre;
use ZEngine\Core as ZEngineCore;
use ZEngine\Reflection\ReflectionClass as ZEngineReflectionClass;

ZEngineCore::init();

if (ini_get('bcmath.scale')) {
    $scale = ini_get('bcmath.scale');
} elseif (ini_get('precision')) {
    $scale = ini_get('precision');
} else {
    $scale = 30;
}
bcscale((int) $scale);

$classes = [
    BigNumber::class,
    // area
    Acre::class,
    SquareCentimeter::class,
    SquareFoot::class,
    SquareKilometer::class,
    SquareMeter::class,
    SquareMillimeter::class,
    // length
    Centimeter::class,
    Foot::class,
    Inch::class,
    Kilometer::class,
    Meter::class,
    Mile::class,
    Millimeter::class,
    Yard::class,
    // speed
    KilometersPerHour::class,
    MetersPerSecond::class,
    MilesPerHour::class,
    // temperature
    Celsius::class,
    Fahrenheit::class,
    Kelvin::class,
    // time
    Day::class,
    Hour::class,
    Microsecond::class,
    Millisecond::class,
    Minute::class,
    Second::class,
    // volume
    Centilitre::class,
    CubicCentimeter::class,
    CubicFoot::class,
    CubicKilometer::class,
    CubicMeter::class,
    CubicMillimeter::class,
    Decilitre::class,
    Litre::class,
    Millilitre::class,
];

foreach ($classes as $class) {
    (new ZEngineReflectionClass($class))->installExtensionHandlers();
}
