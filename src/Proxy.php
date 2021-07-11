<?php

namespace Expect;

use PHPUnit\Framework\Test;

/**
 * @mixin \Expect\Expectation
 */
final class Proxy
{
    public function __construct(
        private Test $test,
        private Expectation $baseExpectation,
        private mixed $expected,
        private bool $all = false,
    ) {
    }

    public function __call(string $name, array $args)
    {
        if ($this->all) {
            /** @var \Expect\Expectation $expect */
            foreach ($this->asExpectations() as $expect) {
                $expect->{$name}(...$args);
            }

            return $this;
        }

        $expect = $this->asExpectation();
        $expect->{$name}(...$args);

        return $this;
    }

    public function __get(string $name)
    {
        return $this->baseExpectation->{$name};
    }

    public function asExpectation(): Expectation
    {
        return new Expectation($this->test, $this->expected);
    }

    public function asExpectations(): \Generator
    {
        /** @var mixed $value */
        foreach ($this->expected as $value) {
            yield new Expectation($this->test, $value);
        }
    }
}
