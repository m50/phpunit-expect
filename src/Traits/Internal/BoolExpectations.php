<?php

namespace Expect\Traits\Internal;

use PHPUnit\Framework\Assert;
use Expect\Expectation;

/**
 * @internal
 */
trait BoolExpectations
{
    abstract public function unNot(): static;
    abstract protected function handleExpectation(callable $c, callable $cNot): void;
    abstract protected function handleExpectationStr(mixed $expected, string $assertName, ?string $notAssertName = null): void;

    /** @psalm-assert bool $this->expected */
    public function toBeBool(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isBool');

        return $this;
    }

    public function toBeTrue(): static
    {
        $this->unNot()->toBeBool();
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'true');

        return $this;
    }

    public function toBeFalse(): static
    {
        $this->unNot()->toBeBool();
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'false');


        return $this;
    }

    public function toBeTruthy(): static
    {
        $this->handleExpectation(
            fn () => Assert::assertTrue((bool) $this->expected),
            fn () => Assert::assertFalse((bool) $this->expected),
        );

        return $this;
    }
}
