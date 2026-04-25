<?php

namespace Aleoosha\Support\Types;

use DivisionByZeroError;

class FixedPoint
{
    public const SCALE = 1000;

    public function __construct(
        public readonly int $value
    ) {}

    public static function fromFloat(float $float): self
    {
        return new self((int) round($float * self::SCALE));
    }

    public static function fromInt(int $integer): self
    {
        return new self($integer * self::SCALE);
    }

    public function toFloat(): float
    {
        return $this->value / self::SCALE;
    }

    public function add(self $other): self
    {
        return new self($this->value + $other->value);
    }

    public function subtract(self $other): self
    {
        return new self($this->value - $other->value);
    }

    public function multiply(self $other): self
    {
        return new self((int) (($this->value * $other->value) / self::SCALE));
    }

    public function divide(self $other): self
    {
        if ($other->value === 0) {
            throw new DivisionByZeroError("Cannot divide FixedPoint by zero.");
        }
        return new self((int) (($this->value * self::SCALE) / $other->value));
    }

    public function isGreaterThan(self $other): bool
    {
        return $this->value > $other->value;
    }

    public function isLessThan(self $other): bool
    {
        return $this->value < $other->value;
    }
}
