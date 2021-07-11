<?php

namespace Tests;

use Expect\Testing\TestCase;

class NumericExpectationsTest extends TestCase
{
    public function testToBeInt()
    {
        $this->expect(4)->toBeInt();
        $this->expect('a')->not->toBeInt();
    }

    public function testToBeFloat()
    {
        $this->expect(4.01)->toBeFloat();
        $this->expect('a')->not->toBeFloat();
    }

    public function testToBeNumeric()
    {
        $this->expect('1')->toBeNumeric();
        $this->expect('a')->not->toBeNumeric();
    }

    public function testToBeGreaterThan()
    {
        $this->expect(4)->toBeGreaterThan(3);
        $this->expect(4)->not->toBeGreaterThan(5);
    }

    public function testToBeGreaterThanOrEqual()
    {
        $this->expect(4)->toBeGreaterThanOrEqual(3);
        $this->expect(4)->toBeGreaterThanOrEqual(4);
        $this->expect(4)->not->toBeGreaterThan(5);
    }
    public function testToBeLessThan()
    {
        $this->expect(4)->toBeLessThan(5);
        $this->expect(4)->not->toBeLessThan(2);
    }

    public function testToBeLessThanOrEqual()
    {
        $this->expect(4)->toBeLessThanOrEqual(5);
        $this->expect(4)->toBeLessThanOrEqual(4);
        $this->expect(4)->not->toBeLessThan(2);
    }
}
