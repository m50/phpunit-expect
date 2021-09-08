<?php

namespace Expect;

use ArrayAccess;
use Closure;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Test;
use Expect\Traits\Internal\ArrayExpectations;
use Expect\Traits\Internal\BoolExpectations;
use Expect\Traits\Internal\NumericExpectations;
use Expect\Traits\Internal\ObjectExpectations;
use Expect\Traits\Internal\StandardExpectations;
use Expect\Traits\Internal\StringExpectations;
use Traversable;

/**
 * @property-read Expectation $not
 */
final class Expectation
{
    use StandardExpectations;
    use ArrayExpectations;
    use StringExpectations;
    use BoolExpectations;
    use ObjectExpectations;
    use NumericExpectations;

    public const NO_EXPECTED_VALUE = '____NO_EXPECTED___';

    public function __construct(
        protected Test $test,
        protected mixed $expected,
        protected bool $shouldNot = false,
    ) {
    }

    public function not(): static
    {
        return new static($this->test, $this->expected, ! $this->shouldNot);
    }

    public function unNot(): static
    {
        return new static($this->test, $this->expected, false);
    }

    public function __call(string $name, array $arguments)
    {
        $name = preg_replace('/^toBe/', '', $name);
        $name = preg_replace('/^toHave/', '', $name);
        $notName = 'assertNot' . ucfirst($name);
        $name = 'assert' . ucfirst($name);
        $arguments[] = $this->expected;

        $not = fn (): mixed => Assert::fail("{$name} failed in `not` scenario.");
        if (method_exists($this->test, $notName)) {
            $not = fn (): mixed => $this->test->$notName(...$arguments);
        }

        $this->handleExpectation(
            fn (): mixed => $this->test->$name(...$arguments),
            $not,
        );

        return $this;
    }

    public function __get(string $name)
    {
        if ($name === 'not' || $name === '!') {
            return $this->not();
        }

        if ($this->isArray() && isset($this->expected[$name])) {
            return new Proxy($this->test, $this, $this->expected[$name]);
        }

        if (\is_object($this->expected) && \property_exists($this->expected, $name)) {
            return new Proxy($this->test, $this, $this->expected->{$name});
        }

        Assert::fail("'{$name}' is not an accessible property.");
    }

    /** @psalm-assert-if-true array $this->expected */
    protected function isArray(): bool
    {
        return \is_array($this->expected) || (
            $this->expected instanceof ArrayAccess && $this->expected instanceof Traversable
        );
    }

    protected function handleExpectationStr(
        mixed $expected,
        string $assertName,
        ?string $notAssertName = null
    ): void {
        $assertName = preg_replace('/^(assert|toBe)/i', '', $assertName);
        $assertName = ucfirst($assertName);
        $fullAssert = "assert{$assertName}";
        if (! method_exists($this->test, $fullAssert)) {
            Assert::fail("'{$fullAssert}' is not a valid assertion.");
        }

        if ($notAssertName === null) {
            $notAssertName = "assertNot{$assertName}";
            if (strtolower(substr($assertName, 0, 2)) === 'is') {
                $notAssertName = 'assertIsNot' . ucfirst(preg_replace('/^is/i', '', $assertName));
            }
            if (! method_exists($this->test, $notAssertName)) {
                Assert::fail("'{$notAssertName}' is not a valid assertion.");
            }
        } else {
            $notAssertName = preg_replace('/^(assert|toBe)/i', '', $notAssertName);
            $notAssertName = ucfirst($notAssertName);
            $notAssertName = "assert{$notAssertName}";
        }

        if ($expected === self::NO_EXPECTED_VALUE) {
            $this->handleExpectation(
                fn (): mixed => $this->test->{$fullAssert}($this->expected),
                fn (): mixed => $this->test->{$notAssertName}($this->expected),
            );

            return;
        }

        $this->handleExpectation(
            fn (): mixed => $this->test->{$fullAssert}($expected, $this->expected),
            fn (): mixed => $this->test->{$notAssertName}($expected, $this->expected),
        );
    }

    protected function handleExpectation(callable $c, callable $cNot): void
    {
        try {
            $closure = Closure::fromCallable($c)->bindTo($this);
            Assert::assertNotFalse($closure);
            $closure();
        } catch (\Throwable $e) {
            if ($this->shouldNot) {
                return;
            }
            throw $e;
        }

        if ($this->shouldNot) {
            $closure = Closure::fromCallable($cNot)->bindTo($this);
            Assert::assertNotFalse($closure);
            $closure();
        }
    }

    public function and(mixed ...$obj): self
    {
        if (count($obj) === 0) {
            $obj = $this->expected;
        } elseif (count($obj) === 1) {
            $obj = $obj[0];
        }

        return new self($this->test, $obj);
    }
}
