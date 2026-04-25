<?php 

declare(strict_types=1);

namespace Aleoosha\Support\Types;

use DivisionByZeroError;

/**
 * FixedPoint - Fixed-point number implementation.
 * Provides high precision for calculations by avoiding floating-point issues.
 */
final class FixedPoint
{
    /**
     * The scale factor: 1000 represents 3 decimal places.
     */
    public const SCALE = 1000;

    /**
     * @param int $value Internal integer representation (actual value * SCALE)
     */
    public function __construct(
        public readonly int $value
    ) {}

    /**
     * Creates a FixedPoint instance from a float value.
     */
    public static function fromFloat(float $float): self
    {
        return new self((int) round($float * self::SCALE));
    }

    /**
     * Creates a FixedPoint instance from an integer value.
     */
    public static function fromInt(int $integer): self
    {
        return new self($integer * self::SCALE);
    }

    /**
     * Converts the internal value back to a float.
     */
    public function toFloat(): float
    {
        return $this->value / self::SCALE;
    }

    /**
     * Adds another FixedPoint value.
     */
    public function add(self $other): self
    {
        return new self($this->value + $other->value);
    }

    /**
     * Subtracts another FixedPoint value.
     */
    public function subtract(self $other): self
    {
        return new self($this->value - $other->value);
    }

    /**
     * Multiplies by another FixedPoint value.
     * Dividing by SCALE is required to maintain the correct fixed-point position.
     */
    public function multiply(self $other): self
    {
        return new self((int) (($this->value * $other->value) / self::SCALE));
    }

    /**
     * Divides by another FixedPoint value.
     * Multiplying the dividend by SCALE is required to maintain precision.
     */
    public function divide(self $other): self
    {
        if ($other->value === 0) {
            throw new DivisionByZeroError("Cannot divide FixedPoint by zero.");
        }

        return new self((int) (($this->value * self::SCALE) / $other->value));
    }

    /**
     * Returns true if the current value is greater than the other.
     */
    public function isGreaterThan(self $other): bool
    {
        return $this->value > $other->value;
    }

    /**
     * Returns true if the current value is less than the other.
     */
    public function isLessThan(self $other): bool
    {
        return $this->value < $other->value;
    }

    /**
     * Returns true if both values are equal.
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
