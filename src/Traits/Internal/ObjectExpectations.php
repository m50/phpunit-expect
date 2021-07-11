<?php

namespace Expect\Traits\Internal;

use Expect\Expectation;
use PHPUnit\Framework\Assert;

/**
 * @internal
 */
trait ObjectExpectations
{
    abstract public function unNot(): static;
    abstract protected function handleExpectationStr(mixed $expected, string $assertName, ?string $notAssertName = null): void;

    /** @psalm-assert object $this->expected */
    public function toBeObject(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isObject');

        return $this;
    }

    /**
     * @template T
     * @psalm-param class-string<T> $class
     * @psalm-assert T $this->expected
     */
    public function toBeInstanceOf(string $class): static
    {
        $this->handleExpectationStr($class, 'instanceOf');

        return $this;
    }

    public function toHaveProperty(string $property): static
    {
        $this->handleExpectationStr($property, 'ClassHasAttribute', 'ClassNotHasAttribute');

        return $this;
    }
}
