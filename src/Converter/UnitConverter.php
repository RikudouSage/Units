<?php

namespace Rikudou\Units\Converter;

use Rikudou\Units\Exception\InvalidConversionException;
use Rikudou\Units\Helper\ObjectValidator;
use Rikudou\Units\Unit\Unit;

final class UnitConverter implements UnitConverterInterface
{
    private ObjectValidator $objectValidator;

    public function __construct()
    {
        $this->objectValidator = new ObjectValidator();
    }

    /**
     * @param class-string $targetClass
     */
    public function convert(Unit $unit, string $targetClass): Unit
    {
        if (!$this->objectValidator->haveCommonAncestors($unit, $targetClass)) {
            throw new InvalidConversionException('Cannot convert units of unrelated fields');
        }

        $defaultUnit = $unit->asDefaultUnit();

        return call_user_func([$targetClass, 'fromDefaultUnit'], $defaultUnit);
    }
}
