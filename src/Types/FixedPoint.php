<?php declare(strict_types=1);

namespace Aleoosha\Support\Types;

use DivisionByZeroError;

/**
 * FixedPoint - High-precision value object for financial and engineering calculations.
 * Avoids floating-point math issues by storing values as integers with a scale factor.
 */
final class FixedPoint
{
    /**
     * The scale factor: 1000 represents 3 decimal places (milli-units).
     */
    public const SCALE = 1000;

    /**
     * @param int $value Internal integer representation (actual value * SCALE).
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
     * Converts the internal value back to a float for display or external API.
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
     * Dividing by SCALE is required to maintain the fixed-point position.
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
     * Comparison: Greater Than (>)
     */
    public function isGreaterThan(self $other): bool
    {
        return $this->value > $other->value;
    }

    /**
     * Comparison: Less Than (<)
     */
    public function isLessThan(self $other): bool
    {
        return $this->value < $other->value;
    }

    /**
     * Comparison: Greater Than or Equal (>=)
     */
    public function isGreaterThanOrEqual(self $other): bool
    {
        return $this->value >= $other->value;
    }

    /**
     * Comparison: Less Than or Equal (<=)
     */
    public function isLessThanOrEqual(self $other): bool
    {
        return $this->value <= $other->value;
    }

    /**
     * Comparison: Equality (==)
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
