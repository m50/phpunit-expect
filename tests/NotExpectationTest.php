<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Expect\Traits\Expect;

class NotExpectationTest extends TestCase
{
    use Expect;

    public function testNot()
    {
        $this->expect('test')->not->toBe('echo');
        $this->expect('test')->not()->toBe('echo');
        try {
            $this->expect('test')->not()->toBe('test');
        } catch (\Throwable $e) {
            $this->expect($e->getMessage())
                ->toBe('Failed asserting that two strings are not identical.');
        }

        $this->expect(false)->not->toBeTruthy();
    }
}
