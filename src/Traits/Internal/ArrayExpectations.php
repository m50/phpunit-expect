<?php

namespace Expect\Traits\Internal;

use Closure;
use Countable;
use PHPUnit\Framework\Assert;
use Expect\Expectation;
use Expect\Proxy;

/**
 * @internal
 */
trait ArrayExpectations
{
    abstract public function unNot(): static;
    abstract protected function handleExpectation(callable $c, callable $cNot): void;
    abstract protected function handleExpectationStr(mixed $expected, string $assertName, ?string $notAssertName = null): void;

    /** @psalm-assert array $this->expected */
    public function toBeArray(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isArray');

        return $this;
    }

    /** @psalm-assert iterable $this->expected */
    public function toBeIterable(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isIterable');

        return $this;
    }

    public function toHaveKey(string|int $key): static
    {
        $this->unNot()->toBeArray();
        $this->handleExpectationStr(
            $key,
            'ArrayHasKey',
            'ArrayNotHasKey'
        );

        return $this;
    }

    public function key(string|int $key): Proxy
    {
        $this->unNot()->toBeArray();
        $this->toHaveKey($key);

        return new Proxy($this->test, $this, $this->expected[$key]);
    }

    public function toContain(mixed $obj): static
    {
        $this->unNot()->toBeArray();
        $this->handleExpectationStr($obj, 'contains');

        return $this;
    }

    public function sequence(callable ...$callables): static
    {
        $this->unNot()->toBeArray();
        foreach ($callables as $key => $callable) {
            $expect = $this->key($key)->asExpectation();
            $callable = Closure::fromCallable($callable)->bindTo($expect);
            Assert::assertNotFalse($callable);
            $callable($expect);
        }

        return $this;
    }

    public function each(callable $callable): static
    {
        $this->unNot()->toBeArray();
        foreach (\array_keys($this->expected) as $key) {
            $expect = $this->key($key)->asExpectation();
            $callable = Closure::fromCallable($callable)->bindTo($expect);
            Assert::assertNotFalse($callable);
            $callable($expect);
        }

        return $this;
    }

    public function toHaveCount(int $count): static
    {
        $this->unNot()->toBeArray();
        $this->handleExpectationStr($count, 'count');

        return $this;
    }

    public function toHaveSameLengthAs(iterable|Countable $other): static
    {
        $this->unNot()->toBeIterable();
        $this->handleExpectationStr($other, 'sameSize');

        return $this;
    }

    public function toBeSameSizeAs(iterable|Countable $other): static
    {
        return $this->toHaveSameLengthAs($other);
    }

    public function all(): Proxy
    {
        return new Proxy($this->test, $this, $this->expected, true);
    }
}
