<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Expect\Traits\Expect;
use Tests\Assets\SomeAttribute;
use Tests\Assets\SomeClass;

class ObjectExpectationsTest extends TestCase
{
    use Expect;

    private static $c;

    protected function setUp(): void
    {
        parent::setUp();
        $c = new \stdClass();
        $c->test = 1;
        $c->test2 = 2;
        self::$c = $c;
    }

    public function testToBeObject()
    {
        $this->expect(self::$c)->toBeObject();
        $this->expect([])->not->toBeObject();
    }

    public function testHigherOrderObject()
    {
        $this->expect(self::$c)
            ->test->toBe(1)
            ->test2->toBe(2)
        ;
    }

    public function testToBeInstanceOf()
    {
        $this->expect(self::$c)->toBeInstanceOf(\stdClass::class);
        $this->expect(new SomeClass())->toBeInstanceOf(SomeClass::class);
        $this->expect(self::$c)->not->toBeInstanceOf(SomeClass::class);
    }

    public function testToHaveProperty()
    {
        $this->expect(SomeClass::class)->toHaveProperty('prop');
        $this->expect(SomeClass::class)->not->toHaveProperty('propX');
    }
}
