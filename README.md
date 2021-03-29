# Property Accessor

[![Tests](https://github.com/felixdorn/property-accessor/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/felixdorn/property-accessor/actions/workflows/tests.yml)
[![Formats](https://github.com/felixdorn/property-accessor/actions/workflows/formats.yml/badge.svg?branch=master)](https://github.com/felixdorn/property-accessor/actions/workflows/formats.yml)
[![Version](https://poser.pugx.org/felixdorn/property-accessor/version)](//packagist.org/packages/felixdorn/property-accessor)
[![Total Downloads](https://poser.pugx.org/felixdorn/property-accessor/downloads)](//packagist.org/packages/felixdorn/property-accessorqqqqqqqq)
[![License](https://poser.pugx.org/felixdorn/property-accessor/license)](//packagist.org/packages/felixdorn/property-accessor)

## Installation

> Requires [PHP7.4.0+](https://php.net/releases)

You can install the package via composer:

```bash
composer require felixdorn/property-accessor
```

## Usage

```php
use function \Felix\PropertyAccessor\access;

class Book {
    protected string $name = 'Harry Potter';
    protected int $isbn = 4408_1224;
}

$object = new Book();
access($object, 'isbn');  // returns 44081224 

// Properties are injected based on the parameter name passed to the function.
access($object, function ($isbn, $name) {
    return $isbn . ' - ' . $name;
});

access($object, ['isbn', 'name']); // returns ['isbn' => 44081224, 'name' => 'Harry Potter']
```

## Testing

```bash
composer test
```

**property-accessor** was created by **[Félix Dorn](https://twitter.com/afelixdorn)** under the **[MIT license](https://opensource.org/licenses/MIT)**.
