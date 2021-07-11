<?php

namespace Tests;

use Expect\Expectation;
use PHPUnit\Framework\TestCase;
use Expect\Traits\Expect;
use Tests\Assets\SomeClass;

class ArrayExpectationsTest extends TestCase
{
    use Expect;

    public function testToBeArray()
    {
        $this->expect([])->toBeArray();

        $v = function () {
            yield 1;
            yield 2;
        };

        $this->expect($v())->not->toBeArray();
    }

    public function testToBeIterable()
    {
        $v = function () {
            yield 1;
            yield 2;
        };

        $this->expect($v())->toBeIterable();
        $this->expect([])->toBeIterable();
    }

    public function testToHaveKey()
    {
        $this->expect(['test' => 1])->toHaveKey('test');
    }

    public function testKey()
    {
        $this->expect(['test' => 1])->key('test')->toBe(1);
    }

    public function testToContain()
    {
        $this->expect(['test'])->toContain('test');
        $this->expect(['test'])->not->toContain('echo');
    }

    public function testHigherOrderArray()
    {
        $this->expect(['test' => 1])->test->toBe(1);
    }

    public function testToHaveCount()
    {
        $this->expect([1, 2, 3])->toHaveCount(3);
    }

    public function testSequence()
    {
        $this->expect([1, 2, 3])->sequence(
            fn (Expectation $e) => $e->toBe(1),
            fn (Expectation $e) => $e->toBe(2),
            fn (Expectation $e) => $e->toBe(3),
        );
    }

    public function testSequenceStringKeys()
    {
        $this->expect(['test' => 1, 'test2' => 2])->sequence(
            test: fn (Expectation $e) => $e->toBe(1),
            test2: fn (Expectation $e) => $e->toBe(2),
        );
    }

    public function testEach()
    {
        $this->expect([1,1,1,1])->each(fn (Expectation $e) => $e->toBe(1));
    }

    public function testHigherOrderChains()
    {
        $this->expect(['test' => 1, 'test2' => 2])
            ->test->toBe(1)
            ->test2->toBe(2);
    }

    public function testAll()
    {
        $this->expect([
            new SomeClass(),
            new SomeClass(),
            new SomeClass(),
        ])->all()->toBeInstanceOf(SomeClass::class);

        $this->expect(1, 2, 3)->all()->toBeInt();
    }

    public function testSameSize()
    {
        $this->expect([1,2,3])->toHaveSameLengthAs([3,2,1]);
        $this->expect([1,2,3])->toBeSameSizeAs([3,2,1]);
    }
}
