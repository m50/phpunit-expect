# PHPUnit Expect

![psalm type coverage](https://shepherd.dev/github/m50/phpunit-expect/coverage.svg)
[![Test](https://github.com/m50/phpunit-expect/actions/workflows/test.yml/badge.svg)](https://github.com/m50/phpunit-expect/actions/workflows/test.yml)
[![styleci status](https://github.styleci.io/repos/384875482/shield)](https://github.styleci.io/repos/384875482)

[![Latest Stable Version](https://poser.pugx.org/m50/phpunit-expect/v/stable)](https://packagist.org/packages/m50/phpunit-expect)
[![Total Downloads](https://poser.pugx.org/m50/phpunit-expect/downloads)](https://packagist.org/packages/m50/phpunit-expect)
[![License](https://poser.pugx.org/m50/phpunit-expect/license)](https://packagist.org/packages/m50/phpunit-expect)

An expectation API for PHPUnit, inspired for Mocha or Jest for JS.

## Install

The best way to install this package is with Composer.

```sh
composer require --dev m50/phpunit-expect
```

## Usage

When writing tests, instead of using the standard assert, you can use expect.

```php
<?php

namespace Tests;

use Expect\Traits\Expect;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    use Expect;

    public function testAdd()
    {
        $this->expect(2 + 2)->toBe(4);
    }
}
```

Any assertion on your test case can be used with this API. For example:

```php
class CustomerAssertTest extends TestCase
{
    use Expect;

    public function assertCustomer($customer, string $message = ''): void
    {
        // Do some assertion
    }

    public function testCustomer()
    {
        // Populate the $customer variable with a possible Customer
        $this->expect($customer)->toBeCustomer();
    }
}
```

It will replace `toBe` or `to` at the beginning of the function name with `assert`, so any assertion
that has not been translated, or any custom assertion you may have, can be utilized with this.

Additionally, you can chain assertions:

```php
public function testStringChain()
{
    $this->expect('Hello World')
        ->toLowerCase() // Converts a string all to lower case, to do case insensitive assertions.
        ->toStartWith('hello')
        ->toEndWith('world')
    ;
}
```

And, it also supports proxied/higher-order expectations:

```php
public function testProxiedCalls()
{
    $this->expect(['first' => 1, 'second' => 2])
        ->first->toBe(1)
        ->second->toBe(2)
    ;

    $class = new \stdClass();
    $class->first = 1;
    $class->second = 2;

    $this->expect($class)
        ->first->toBe(1)
        ->second->toBe(2)
    ;
}

public function testSequence()
{
    $this->expect(['first' => 1, 'second' => 2])->sequence(
        first: fn (Expectation $e) => $e->toBe(1),
        second: fn(Expectation $e) => $e->toBe(2),
    );

    $class = new \stdClass();
    $class->first = 1;
    $class->second = 2;
}
```

## License

PHPUnit-Expect is open-sourced software licensed under the [MIT license](LICENSE).
