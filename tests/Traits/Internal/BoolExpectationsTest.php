<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Expect\Traits\Expect;

class BoolExpectationsTest extends TestCase
{
    use Expect;

    public function testToBeBool()
    {
        $this->expect(true)->toBeBool();
        $this->expect('hi')->not->toBeBool();
    }

    public function testToBeTrue()
    {
        $this->expect(true)->toBeTrue();
    }

    public function testToBeFalse()
    {
        $this->expect(false)->toBeFalse();
    }

    public function testToBeTruthy()
    {
        $this->expect('test')->toBeTruthy();
        $this->expect(0)->not->toBeTruthy();
    }
}
