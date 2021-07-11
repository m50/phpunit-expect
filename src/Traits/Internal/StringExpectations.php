<?php

namespace Expect\Traits\Internal;

use PHPUnit\Framework\Assert;
use Expect\Expectation;

/**
 * @internal
 */
trait StringExpectations
{
    abstract public function unNot(): static;
    abstract protected function handleExpectation(callable $c, callable $cNot): void;
    abstract protected function handleExpectationStr(mixed $expected, string $assertName, ?string $notAssertName = null): void;

    /** @psalm-assert string $this->expected */
    public function toBeString(): static
    {
        $this->handleExpectationStr(Expectation::NO_EXPECTED_VALUE, 'isString');

        return $this;
    }

    public function toMatchRegex(string $pattern): static
    {
        $this->unNot()->toBeString();
        $this->handleExpectationStr(
            $pattern,
            'MatchesRegularExpression',
            'DoesNotMatchRegularExpression',
        );

        return $this;
    }

    public function toContainString(string $needle): static
    {
        $this->unNot()->toBeString();
        $this->handleExpectationStr($needle, 'StringContainsString', 'StringNotContainsString');

        return $this;
    }

    public function toLowerCase(): static
    {
        $this->unNot()->toBeString();

        return new self($this->test, strtolower($this->expected), $this->shouldNot);
    }

    public function toMatchFormat(string $format): static
    {
        $this->unNot()->toBeString();
        $this->handleExpectationStr($format, 'StringMatchesFormat', 'StringNotMatchesFormat');

        return $this;
    }

    public function toStartWith(string $start): static
    {
        $this->unNot()->toBeString();
        $this->handleExpectationStr($start, 'StringStartsWith', 'StringStartsNotWith');

        return $this;
    }

    public function toEndWith(string $end): static
    {
        $this->unNot()->toBeString();
        $this->handleExpectationStr($end, 'StringEndsWith', 'StringEndsNotWith');

        return $this;
    }
}
