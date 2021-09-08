<?php

namespace Tests;

use Expect\Testing\TestCase;

class ExpectationTest extends TestCase
{
    public function testToBe()
    {
        $this->expect(2 + 2)->toBe(4);
        $this->expect(2 + 2)->not->toBe(5);

        $c1 = new \stdClass();
        $c1->test = 'test';

        $c2 = new \stdClass();
        $c2->test = 'test';

        try {
            $this->expect($c1)->toBe($c2);
        } catch (\Throwable $e) {
            $this->expect($e->getMessage())
                ->toBe('Failed asserting that two variables reference the same object.');
        }
    }

    public function testToEqual()
    {
        $this->expect(2 + 2)->toEqual(4);
        $this->expect(2 + 2)->not->toEqual(5);

        $c1 = new \stdClass();
        $c1->test = 'test';

        $c2 = new \stdClass();
        $c2->test = 'test';

        $this->expect($c1)->toEqual($c2);
    }

    public function testChaining()
    {
        $this->expect('test')
            ->toBe('test')
            ->not->toEqual('echo');
    }

    public function testToBeNull()
    {
        $this->expect(null)->toBeNull();
        $this->expect('hi')->not->toBeNull();
    }

    public function testToBeEmpty()
    {
        $this->expect([])->toBeEmpty();
        $this->expect('')->toBeEmpty();
    }

    public function testToBeScalar()
    {
        $this->expect('')->toBeScalar();
    }

    public function testToBeCallable()
    {
        $this->expect(fn () => '')->toBeCallable();
    }

    public function testResult()
    {
        $this->expect(fn () => '')->result()->toBeString();
    }

    public function testToBeJson()
    {
        $this->expect('{"key":"value"}')->toBeJson();
        $this->expect('hi')->not->toBeJson();
    }

    public function testAnd()
    {
        $this->expect(1)->toBe(1)
            ->and(2)->not->toBe(1);
    }
}
