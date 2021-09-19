<?php

namespace Rikudou\Units\Number;

use Rikudou\Units\Exception\InvalidNumberException;
use Rikudou\Units\Exception\UnsupportedCastType;
use RuntimeException;
use function setlocale;
use ZEngine\ClassExtension\Hook\CastObjectHook;
use ZEngine\ClassExtension\Hook\CompareValuesHook;
use ZEngine\ClassExtension\Hook\DoOperationHook;
use ZEngine\ClassExtension\ObjectCastInterface;
use ZEngine\ClassExtension\ObjectCompareValuesInterface;
use ZEngine\ClassExtension\ObjectCreateInterface;
use ZEngine\ClassExtension\ObjectCreateTrait;
use ZEngine\ClassExtension\ObjectDoOperationInterface;
use ZEngine\Reflection\ReflectionValue;
use ZEngine\System\OpCode;

final class BigNumber implements
    ObjectCreateInterface,
    ObjectDoOperationInterface,
    ObjectCompareValuesInterface,
    ObjectCastInterface
{
    use ObjectCreateTrait;

    private string $value;

    /**
     * @param string|int|float|BigNumber|object $value
     */
    public function __construct($value)
    {
        $this->value = self::getNumericRepresentation($value);
    }

    public static function __doOperation(DoOperationHook $hook): BigNumber
    {
        $map = [
            OpCode::ADD => 'bcadd',
            OpCode::SUB => 'bcsub',
            OpCode::MUL => 'bcmul',
            OpCode::DIV => 'bcdiv',
            OpCode::POW => 'bcpow',
        ];

        $operation = $map[$hook->getOpcode()] ?? null;
        if ($operation === null) {
            throw new RuntimeException("Unsupported operation opcode: {$hook->getOpcode()}");
        }

        $left = self::getNumericRepresentation($hook->getFirst());
        $right = self::getNumericRepresentation($hook->getSecond());

        return new BigNumber($operation($left, $right));
    }

    public static function __cast(CastObjectHook $hook)
    {
        $object = $hook->getObject();
        assert($object instanceof self);

        $type = $hook->getCastType();
        switch ($type) {
            case ReflectionValue::IS_LONG:
                return (int) $object->value;
            case ReflectionValue::IS_DOUBLE:
                return (float) $object->value;
            case ReflectionValue::IS_STRING:
                return self::getDisplayString($object->value);
            case ReflectionValue::_IS_BOOL:
                return (bool) $object->value;
            case ReflectionValue::_IS_NUMBER:
                $string = self::getDisplayString($object->value);
                if (strpos($string, '.') !== false) {
                    return (float) $string;
                }

                return (int) $string;
            default:
                throw new UnsupportedCastType("Unsupported cast type: {$type}");
        }
    }

    public static function __compare(CompareValuesHook $hook): int
    {
        return bccomp(
            self::getNumericRepresentation($hook->getFirst()),
            self::getNumericRepresentation($hook->getSecond())
        );
    }

    public function __toString()
    {
        return self::getDisplayString($this->value);
    }

    /**
     * @param string|int|float|BigNumber|object $value
     */
    private static function getNumericRepresentation($value): string
    {
        if (is_int($value) || is_float($value)) {
            $currentLocale = setlocale(LC_NUMERIC, '0');
            setlocale(LC_NUMERIC, 'C');
            $value = (string) $value;
            if (is_string($currentLocale)) {
                setlocale(LC_NUMERIC, $currentLocale);
            }
        } elseif ($value instanceof BigNumber) {
            $value = $value->value;
        } elseif (is_object($value) && method_exists($value, '__toString')) {
            $value = (string) $value;
        }

        if (!is_string($value)) {
            throw new InvalidNumberException(sprintf(
                'Unsupported value type: %s',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return $value;
    }

    private static function getDisplayString(string $value): string
    {
        if (strpos($value, '.') === false) {
            return $value;
        }

        $value = rtrim($value, '0');
        if (substr($value, -1) === '.') {
            $value = substr($value, 0, -1);
        }

        return $value;
    }
}
