# Unit converter and calculator

This library uses the awesome [lisachenko/z-engine](https://github.com/lisachenko/z-engine) to allow mathematical
operations on objects, allowing to do stuff like this:

```php
<?php

use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Foot;

$meter = new Meter(5);
$feet = new Foot(15);

$result = $meter + $feet;
var_dump($result->getValue()); // dumps object of Rikudou\Units\Number\BigNumber which holds the value 9.572 
```

You need to have ffi enabled and bcmath extension installed.

The units are always in the unit that's first in the operation, meaning if you wanted the result in feet you would
just reverse them (or convert them, more on that below):

```php
<?php

use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Foot;

$meter = new Meter(5);
$feet = new Foot(15);

$result = $feet + $meter;
var_dump($result->getValue()); // dumps object of Rikudou\Units\Number\BigNumber which holds the value 31.40419947506561
```

The value is always an instance of `Rikudou\Units\Number\BigNumber` which can be cast to int, float, bool and string.
Casting to int and float may be unsafe if working with large numbers.

```php
<?php

use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Number\BigNumber;

$meter = new Meter(5);
$value = $meter->getValue();

var_dump((int) $value); // int(5)
var_dump((float) $value); // float(5)
var_dump((string) $value); // string(1) "5"
var_dump((bool) $value); // bool(true)

$veryBigValue = $meter * PHP_INT_MAX;
$value = $veryBigValue->getValue();
var_dump((string) $value); // on 64 bit correctly prints string(20) "46116860184273879035"
var_dump((int) $value); // prints int(9223372036854775807) which is the value of PHP_INT_MAX on 64 bits
var_dump((float) $value); // prints float(4.6116860184274E+19) which is more or less correct but not very precise

// BigNumbers follow standard bool logic
$number = new BigNumber(0);
var_dump((bool) $number); // bool(false)
```

`BigNumber` allows standard mathematical operations with other `BigNumber`s, ints, floats, strings and objects
implementing `__toString()` method. Operations always return a new instance of `BigNumber`.

```php
<?php

use Rikudou\Units\Number\BigNumber;

$number = new BigNumber(10);

var_dump($number + $number); // BigNumber with value 20
var_dump($number + 10); // BigNumber with value 20
var_dump($number + 10.5); // BigNumber with value 20.5
var_dump($number + '10'); // BigNumber with value 20

$stringableObject = new class {
    public function __toString(): string {
        return '10';
    }
};

var_dump($number + $stringableObject); // BigNumber with value 20
```

These standard mathematical operations are supported on `BigNumber`s:
 - addition
 - subtraction
 - multiplication
 - division
 - exponentiation

## Installation

`composer require rikudou/units`

## Operations with units

All items of the same type can be freely added and subtracted. Additionally all units can be added, subtracted, multiplied
and divided by numbers (BigNumber, string, int, float, stringable objects). Some units can also be multiplied and divided
by other units where it makes sense (e.g. length units multiplied result in area units, area units divided by length units
result in length units). Adding between unrelated units (like length and area) that don't make sense are not supported.

```php
<?php

use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Centimeter;

$meter = new Meter(1);
$centimeter = new Centimeter(10);

var_dump($meter + $centimeter); // 1.1 meters
var_dump($meter - $centimeter); // 0.9 meters
var_dump($meter * $centimeter); // 0.1 square meters
var_dump($meter / $centimeter); // error
var_dump($meter * 2); // 2 meters
var_dump($meter / 2); // 0.5 meters
var_dump($meter ** 2); // 1 square meter
var_dump($meter ** 3); // 1 cubic meter
var_dump($meter ** 4); // error

$squareMeter = $meter ** 2;
var_dump($squareMeter / $meter); // 1 meter
var_dump($squareMeter * $meter); // 1 cubic meter
var_dump($squareMeter * $squareMeter); // error
var_dump($squareMeter / $squareMeter); // error

$cubicMeter = $meter ** 3;
var_dump($cubicMeter / $squareMeter); // 1 meter
var_dump($cubicMeter / $meter); // 1 square meter
```

You can also freely work with units from different systems:

```php
<?php

use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Yard;

$meter = new Meter(1);
$yard = new Yard(1);

var_dump($meter + $yard); // 1.9144 meters
var_dump($meter - $yard); // 0.0856 meters
var_dump($meter * $yard); // 0.9144 square meters

var_dump($yard + $meter); // 2.0936132983377 yards
```

The order of operations matters as the first unit is the one result will be converted to. If you want to convert the
result to different units you can use the `UnitConverter` object:

```php
<?php

use Rikudou\Units\Converter\UnitConverter;
use Rikudou\Units\Unit\Length\Foot;
use Rikudou\Units\Unit\Length\Yard;
use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Temperature\Celsius;
use Rikudou\Units\Unit\Temperature\Fahrenheit;

$converter = new UnitConverter();

$yards = new Yard(10);
$feet = new Foot(10);

$result = $yards + $feet;
$meters = $converter->convert($result, Meter::class);
var_dump($meters); // 12.19199999999999 meters

$celsius = new Celsius(100);
var_dump($converter->convert($celsius, Fahrenheit::class)); // 212 fahrenheits
```

## Supported Units

### Length

- millimeter
- centimeter
- meter
- kilometer
- inch
- foot
- yard
- mile

### Area

- square millimeter
- square centimeter
- square meter
- square kilometer
- square foot
- acre

### Volume

- cubic millimeter
- cubic centimeter
- cubic meter
- cubic kilometer
- cubic foot
- litre
- millilitre
- centilitre
- decilitre

### Temperature

- celsius
- fahrenheit
- kelvin

If you'd like another unit supported, please [create an issue](https://github.com/RikudouSage/Units/issues/new).

## Comparing

You can compare related units together:

```php
<?php

use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Centimeter;
use Rikudou\Units\Unit\Temperature\Celsius;
use Rikudou\Units\Unit\Temperature\Fahrenheit;

$meter = new Meter(1);
$centimeters = new Centimeter(100);

var_dump($meter > $centimeters); // false
var_dump($meter < $centimeters); // false
var_dump($meter == $centimeters); // true
var_dump($meter >= $centimeters); // true
var_dump($meter <= $centimeters); // true

$celsius = new Celsius(100);
$fahrenheit = new Fahrenheit(100);

var_dump($celsius > $fahrenheit); // true
```

The same works for `BigNumber`s:

```php
<?php

use Rikudou\Units\Number\BigNumber;

$number = new BigNumber(5);

var_dump($number > 4); // true
var_dump($number > 6); // false
var_dump($number > 4.5); // true
var_dump($number > '4'); // true
var_dump($number > new BigNumber(3)); // true
```

## String Casting

When a unit is cast to a string, the value and unit is printed:

```php
<?php

use Rikudou\Units\Unit\Length\Meter;
use Rikudou\Units\Unit\Length\Inch;
use Rikudou\Units\Unit\Length\Foot;

$meters = new Meter(5);
$metersSquared = $meters ** 2;
$metersCubic = $meters ** 3;
$inches = new Inch(5);
$feet = new Foot(3.5);

var_dump((string) $meters); // string(3) "5 m"
var_dump((string) $metersSquared); // string(6) "25 m²"
var_dump((string) $metersCubic); // string(7) "125 m³"
var_dump((string) $inches); // string(4) "5″"
var_dump((string) $feet); // string(8) "3′6″"
```

As you can see, the feet have a special casting where decimals are converted to inches.
