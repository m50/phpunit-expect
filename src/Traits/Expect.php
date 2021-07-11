<?php

namespace Expect\Traits;

use Expect\Expectation;
use PHPUnit\Framework\Assert;

trait Expect
{
    protected function expect(mixed ...$obj): Expectation
    {
        if (count($obj) < 1) {
            Assert::fail('Expect requires at least one parameter.');
        }

        if (count($obj) === 1) {
            return new Expectation($this, $obj[0]);
        }

        return new Expectation($this, $obj);
    }
}
