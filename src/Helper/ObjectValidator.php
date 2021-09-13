<?php

namespace Rikudou\Units\Helper;

use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use Rikudou\Units\Unit\Unit;
use ZEngine\ClassExtension\ObjectCastInterface;
use ZEngine\ClassExtension\ObjectCompareValuesInterface;
use ZEngine\ClassExtension\ObjectCreateInterface;
use ZEngine\ClassExtension\ObjectDoOperationInterface;

/**
 * @internal
 */
final class ObjectValidator
{
    /**
     * @param Unit|class-string $classOrObject1
     * @param Unit|class-string $classOrObject2
     *
     * @throws ReflectionException
     */
    public function haveCommonAncestors($classOrObject1, $classOrObject2): bool
    {
        $reflection1 = is_object($classOrObject1)
            ? new ReflectionObject($classOrObject1)
            : new ReflectionClass($classOrObject1);
        $reflection2 = is_object($classOrObject2)
            ? new ReflectionObject($classOrObject2)
            : new ReflectionClass($classOrObject2);

        $filter = fn (array $interfaces) => array_filter($interfaces, fn (string $interface) => !in_array(
            $interface,
            [
                Unit::class,
                ObjectCreateInterface::class,
                ObjectDoOperationInterface::class,
                ObjectCompareValuesInterface::class,
                ObjectCastInterface::class,
            ],
            true
        ));

        $interfaces1 = $filter($reflection1->getInterfaceNames());
        $interfaces2 = $filter($reflection2->getInterfaceNames());

        return count(array_intersect($interfaces1, $interfaces2)) > 0;
    }
}
