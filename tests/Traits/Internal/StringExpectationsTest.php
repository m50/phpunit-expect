<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Expect\Traits\Expect;

class StringExpectationsTest extends TestCase
{
    use Expect;

    public function testToBeString()
    {
        $this->expect('test')->toBeString();
        $this->expect(1)->not->toBeString();
    }

    public function testToMatchRegex()
    {
        $this->expect('test')->toMatchRegex('/t.../');
        $this->expect('test')->not->toMatchRegex('/k.../');
    }

    public function testToContainsString()
    {
        $this->expect('test')->toContainString('st');
        $this->expect('test')->not->toContainString('k');
    }

    public function testToLowerCase()
    {
        $this->expect('Test')->toLowerCase()->toBe('test');
    }

    public function testToMatchFormat()
    {
        $this->expect('test 1')->toMatchFormat('test %d');
        $this->expect('test 1')->not->toMatchFormat('test %0.2f');
    }

    public function testToStartWith()
    {
        $this->expect('test')->toStartWith('te');
        $this->expect('test')->not->toStartWith('st');
    }

    public function testToEndWith()
    {
        $this->expect('test')->toEndWith('st');
        $this->expect('test')->not->toEndWith('te');
    }
}
