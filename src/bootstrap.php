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
use Rikudou\Units\Unit\Temperature\Celsius;
use Rikudou\Units\Unit\Temperature\Fahrenheit;
use Rikudou\Units\Unit\Temperature\Kelvin;
use Rikudou\Units\Unit\Volume\CubicCentimeter;
use Rikudou\Units\Unit\Volume\CubicFoot;
use Rikudou\Units\Unit\Volume\CubicKilometer;
use Rikudou\Units\Unit\Volume\CubicMeter;
use Rikudou\Units\Unit\Volume\CubicMillimeter;
use ZEngine\Core;
use ZEngine\Reflection\ReflectionClass as ZEngineReflectionClass;

Core::init();
bcscale((int) ini_get('precision'));

(new ZEngineReflectionClass(BigNumber::class))->installExtensionHandlers();

(new ZEngineReflectionClass(Acre::class))->installExtensionHandlers();
(new ZEngineReflectionClass(SquareCentimeter::class))->installExtensionHandlers();
(new ZEngineReflectionClass(SquareFoot::class))->installExtensionHandlers();
(new ZEngineReflectionClass(SquareKilometer::class))->installExtensionHandlers();
(new ZEngineReflectionClass(SquareMeter::class))->installExtensionHandlers();
(new ZEngineReflectionClass(SquareMillimeter::class))->installExtensionHandlers();

(new ZEngineReflectionClass(Centimeter::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Foot::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Inch::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Kilometer::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Meter::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Mile::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Millimeter::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Yard::class))->installExtensionHandlers();

(new ZEngineReflectionClass(Celsius::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Fahrenheit::class))->installExtensionHandlers();
(new ZEngineReflectionClass(Kelvin::class))->installExtensionHandlers();

(new ZEngineReflectionClass(CubicCentimeter::class))->installExtensionHandlers();
(new ZEngineReflectionClass(CubicFoot::class))->installExtensionHandlers();
(new ZEngineReflectionClass(CubicKilometer::class))->installExtensionHandlers();
(new ZEngineReflectionClass(CubicMeter::class))->installExtensionHandlers();
(new ZEngineReflectionClass(CubicMillimeter::class))->installExtensionHandlers();
