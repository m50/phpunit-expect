<?php

namespace Expect\Testing;

use PHPUnit\Framework\TestCase as FrameworkTestCase;
use Expect\Traits\Expect;

abstract class TestCase extends FrameworkTestCase
{
    use Expect;
}
