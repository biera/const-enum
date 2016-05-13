<?php

namespace Biera;

use Biera\BaseValueObject;

/**
 * ConstEnum
 *
 * @author Jakub Biernacki <kubiernacki@gmail.com>
 * @package Biera
 */
abstract class ConstEnum extends BaseValueObject
{
    /**
     * @var scalar
     */
    protected $value;

    /**
     * @param scalar $value
     */
    final private function __construct($value)
    {
        $validValues = self::validValues();

        if(!is_scalar($value) || !in_array($value, $validValues, true)) {
            throw new \InvalidArgumentException(
                sprintf('Parameter should be scalar and has one of the following values: %s.', implode(', ', $validValues))
            );
        }

        $this->value = $value;
    }

    /**
     * @param scalar $value
     *
     * @return ConstEnum
     */
    public static function create($value)
    {
        return new static($value);
    }

    /**
     * @return scalar
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Get valid values
     *
     * @return array
     */
    protected static function validValues()
    {
        $sRef = new \ReflectionClass(static::class);

        $validValues = array_filter(
            $sRef->getConstants(),
            function($const) {
                return is_scalar($const);
            }
        );

        if (empty($validValues)) {
            throw new \LogicException(
                sprintf('Class %s should define at least one constant with scalar value', static::class)
            );
        }

        return array_values($validValues);
    }

    /**
     * Cast to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}