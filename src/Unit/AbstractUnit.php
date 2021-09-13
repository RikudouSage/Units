<?php

namespace Rikudou\Units\Unit;

use Rikudou\Units\Helper\ObjectValidator;
use Rikudou\Units\Number\BigNumber;
use RuntimeException;
use ZEngine\ClassExtension\Hook\CompareValuesHook;
use ZEngine\ClassExtension\Hook\DoOperationHook;
use ZEngine\ClassExtension\ObjectCompareValuesInterface;
use ZEngine\ClassExtension\ObjectCreateInterface;
use ZEngine\ClassExtension\ObjectCreateTrait;
use ZEngine\ClassExtension\ObjectDoOperationInterface;
use ZEngine\System\OpCode;

abstract class AbstractUnit implements Unit, ObjectCreateInterface, ObjectDoOperationInterface, ObjectCompareValuesInterface
{
    use ObjectCreateTrait;

    protected BigNumber $value;

    /**
     * @param int|float|string|BigNumber $value
     */
    final public function __construct($value)
    {
        $this->value = new BigNumber($value);
    }

    public static function __doOperation(DoOperationHook $hook)
    {
        $first = $hook->getFirst();
        $second = $hook->getSecond();

        $target = $first instanceof Unit ? $first : $second;
        $other = $first === $target ? $second : $first;
        $targetClass = get_class($target);

        $value1 = self::getDefaultUnitRepresentation($first);
        $value2 = self::getDefaultUnitRepresentation($second);

        if (self::areBothUnits($first, $second) && method_exists($targetClass, 'getAllowedUnits')) {
            $allowed = $target->getAllowedUnits();
            if (!isset($allowed[$hook->getOpcode()])) {
                throw new RuntimeException(sprintf(
                    "Operation '%s' is not allowed between instances of '%s' and '%s'",
                    self::getOperationName($hook->getOpcode()),
                    get_class($first),
                    get_class($second)
                ));
            }
            $found = false;
            foreach ($allowed[$hook->getOpcode()] as $allowedClass) {
                if (is_a($other, $allowedClass, true)) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                throw new RuntimeException(sprintf(
                    "Operation '%s' is not allowed between instances of '%s' and '%s'",
                    self::getOperationName($hook->getOpcode()),
                    get_class($first),
                    get_class($second)
                ));
            }
        }

        switch ($hook->getOpcode()) {
            case OpCode::ADD:
                $value = $value1 + $value2;
                break;
            case OpCode::SUB:
                $value = $value1 - $value2;
                break;
            case OpCode::MUL:
                if (self::areBothUnits($first, $second)) {
                    if (method_exists($target, 'multiplyTwoUnits')) {
                        return call_user_func([$target, 'multiplyTwoUnits'], $first, $second);
                    }

                    return self::multiplyTwoUnits($first, $second);
                }
                $value = $value1 * $value2;
                break;
            case OpCode::DIV:
                if (self::areBothUnits($first, $second)) {
                    if (method_exists($target, 'divideTwoUnits')) {
                        return call_user_func([$target, 'divideTwoUnits'], $first, $second);
                    }

                    return self::divideTwoUnits($first, $second);
                } elseif (!$first instanceof Unit) {
                    throw new RuntimeException(sprintf(
                        'Cannot divide a number by an instance of %s',
                        get_class($second)
                    ));
                }
                $value = $value1 / $value2;
                break;
            case OpCode::POW:
                if (self::areBothUnits($first, $second)) {
                    if (method_exists($target, 'exponentiateTwoUnits')) {
                        return call_user_func([$target, 'exponentiateTwoUnits'], $first, $second);
                    }

                    return self::exponentiateTwoUnits($first, $second);
                } elseif (!$first instanceof Unit) {
                    throw new RuntimeException(sprintf(
                        'Cannot exponentiate a number by an instance of %s',
                        get_class($second)
                    ));
                } elseif (method_exists($target, 'exponentiate')) {
                    return call_user_func([$target, 'exponentiate'], $first, $second);
                }

                $value = self::exponentiate($first, $second);
                break;
            default:
                throw new RuntimeException("Unsupported operation: [OpCode {$hook->getOpcode()}]");
        }

        $defaultUnitClass = $target::getDefaultUnitClass();

        return call_user_func([$targetClass, 'fromDefaultUnit'], new $defaultUnitClass($value));
    }

    public static function __compare(CompareValuesHook $hook): int
    {
        $first = $hook->getFirst();
        $second = $hook->getSecond();

        if (is_scalar($first)) {
            $class = get_class($second);
            $first = new $class($first);
        }
        if (is_scalar($second)) {
            $class = get_class($first);
            $second = new $class($second);
        }

        if (!$first instanceof Unit || !$second instanceof Unit) {
            throw new RuntimeException(sprintf(
                "Cannot compare between '%s' and '%s'",
                is_object($first) ? get_class($first) : gettype($first),
                is_object($second) ? get_class($second) : gettype($second)
            ));
        }

        $validator = new ObjectValidator();
        if (!$validator->haveCommonAncestors($first, $second)) {
            throw new RuntimeException(sprintf(
                "Cannot compare between instances of '%s' and '%s'",
                get_class($first),
                get_class($second)
            ));
        }

        return $first->asDefaultUnit()->getValue() <=> $second->asDefaultUnit()->getValue();
    }

    public function __toString()
    {
        return ((string) $this->value) . ' ' . $this->getSymbol();
    }

    public function asDefaultUnit(): Unit
    {
        $conversion = $this->getConversionToDefaultUnit();
        if (is_callable($conversion)) {
            $value = $conversion($this->value);
        } else {
            $value = $this->value * $conversion;
        }

        $class = $this->getDefaultUnitClass();

        return new $class($value);
    }

    public static function fromDefaultUnit(Unit $from): self
    {
        if (!is_a($from, static::getDefaultUnitClass(), true)) {
            throw new RuntimeException(sprintf('Unit %s is not a default unit', get_class($from)));
        }
        $conversion = static::getConversionFromDefaultUnit();
        if (is_callable($conversion)) {
            $value = $conversion($from->getValue());
        } else {
            $value = $from->getValue() / $conversion;
        }

        return new static($value);
    }

    public function getValue(): BigNumber
    {
        return $this->value;
    }

    /**
     * @return class-string
     */
    abstract protected static function getDefaultUnitClass(): string;

    /**
     * @return BigNumber|callable
     */
    abstract protected static function getConversionToDefaultUnit();

    /**
     * @return BigNumber|callable
     */
    protected static function getConversionFromDefaultUnit()
    {
        return static::getConversionToDefaultUnit();
    }

    protected static function multiplyTwoUnits(Unit $left, Unit $right): Unit
    {
        throw new RuntimeException(sprintf(
            "Cannot multiply between '%s' and '%s'.",
            get_class($left),
            get_class($right)
        ));
    }

    protected static function divideTwoUnits(Unit $left, Unit $right): Unit
    {
        throw new RuntimeException(sprintf(
            "Cannot divide between '%s' and '%s'.",
            get_class($left),
            get_class($right)
        ));
    }

    protected static function exponentiateTwoUnits(Unit $left, Unit $right): Unit
    {
        throw new RuntimeException(sprintf(
            "Cannot exponentiate instance of '%s' with instance of '%s'.",
            get_class($left),
            get_class($right)
        ));
    }

    /**
     * @param Unit                       $left
     * @param int|float|string|BigNumber $right
     *
     * @return Unit
     */
    protected static function exponentiate(Unit $left, $right): Unit
    {
        throw new RuntimeException(sprintf(
            "Don't know how to exponentiate between a unit of type %s and a number",
            get_class($left),
        ));
    }

    /**
     * @return array<int, class-string[]>
     */
    abstract protected function getAllowedUnits(): array;

    /**
     * @param int|float|string|BigNumber $value
     *
     * @return BigNumber
     */
    protected static function getDefaultUnitRepresentation($value): BigNumber
    {
        if ($value instanceof Unit) {
            return $value->asDefaultUnit()->getValue();
        }

        return new BigNumber($value);
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    private static function areBothUnits($value1, $value2): bool
    {
        return $value1 instanceof Unit && $value2 instanceof Unit;
    }

    private static function getOperationName(int $opCode): string
    {
        switch ($opCode) {
            case OpCode::ADD:
                return 'addition';
            case OpCode::SUB:
                return 'subtraction';
            case OpCode::MUL:
                return 'multiplication';
            case OpCode::DIV:
                return 'division';
            default:
                return "OpCode[{$opCode}]";
        }
    }
}
