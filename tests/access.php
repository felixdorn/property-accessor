<?php

use function Felix\PropertyAccessor\access;
use Felix\PropertyAccessor\Exceptions\PropertyDoesNotExist;

class _SomeObject
{
    protected $andAnotherOne = [444];
    private $property        = 'hello';
    private $anotherOne;
}

it('can access one property', function () {
    $object = new _SomeObject();
    expect(
        access($object, 'property')
    )->toBe('hello');
});

it('can access multiple properties', function () {
    $object = new _SomeObject();
    expect(
        access($object, ['property', 'anotherOne'])
    )->toBe(['property' => 'hello', 'anotherOne' => null]);
});
it('can access multiple properties with a function', function () {
    $object = new _SomeObject();
    access($object, function ($property, $anotherOne, $andAnotherOne) {
        expect($property)->toBe('hello');
        expect($anotherOne)->toBeNull();
        expect($andAnotherOne)->toBe([444]);
    });
});

it('throws an exception if the property does not exist', function () {
    $object = new _SomeObject();
    access($object, function ($doesNotExist) {
    });
})->throws(PropertyDoesNotExist::class);
