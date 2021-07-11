<?php

namespace Expect\Traits\Internal;

use Expect\Expectation;

/**
 * @internal
 */
trait NumericExpectations
{
    abstract public function unNot(): static;
    abstract protected function handleExpectationStr(mixed $expected, string $assertName, ?string $notAssertName = null): void;

    /** @psalm-assert int $this->expected */
    public function toBeInt(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isInt');

        return $this;
    }

    /** @psalm-assert float $this->expected */
    public function toBeFloat(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isFloat');

        return $this;
    }

    /** @psalm-assert int|float $this->expected */
    public function toBeNumeric(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isNumeric');

        return $this;
    }

    public function toBeGreaterThan(float|int $value): static
    {
        $this->handleExpectationStr($value, 'greaterThan', 'lessThanOrEqual');

        return $this;
    }

    public function toBeGreaterThanOrEqual(float|int $value): static
    {
        $this->handleExpectationStr($value, 'greaterThanOrEqual', 'lessThan');

        return $this;
    }

    public function toBeLessThan(float|int $value): static
    {
        $this->handleExpectationStr($value, 'lessThan', 'greaterThanOrEqual');

        return $this;
    }

    public function toBeLessThanOrEqual(float|int $value): static
    {
        $this->handleExpectationStr($value, 'lessThanOrEqual', 'greaterThan');
        return $this;
    }
}
