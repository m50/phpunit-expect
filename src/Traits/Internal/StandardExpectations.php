<?php

namespace Expect\Traits\Internal;

use PHPUnit\Framework\Assert;
use Expect\Expectation;

/**
 * @internal
 */
trait StandardExpectations
{
    abstract public function unNot(): static;
    abstract protected function handleExpectation(callable $c, callable $cNot): void;
    abstract protected function handleExpectationStr(mixed $expected, string $assertName, ?string $notAssertName = null): void;

    public function toBe(mixed $obj): static
    {
        $this->handleExpectationStr($obj, 'same');

        return $this;
    }

    public function toEqual(mixed $obj): static
    {
        $this->handleExpectationStr($obj, 'equals');

        return $this;
    }

    public function toBeNull(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'null');

        return $this;
    }

    public function toBeEmpty(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'empty');

        return $this;
    }

    public function toBeScalar(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isScalar');

        return $this;
    }

    /** @psalm-assert callable $this->expected */
    public function toBeCallable(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isCallable');

        return $this;
    }

    /** @psalm-assert string $this->expected */
    public function toBeJson(): static
    {
        $this->handleExpectation(
            fn () => Assert::assertJson((string) $this->expected),
            fn () => Assert::assertThat((string) $this->expected, Assert::logicalNot(Assert::isJson())),
        );

        return $this;
    }

    public function result(mixed ...$args): static
    {
        $this->unNot()->toBeCallable();

        return new Expectation($this->test, ($this->expected)(...$args));
    }
}
