<?php

use Aleoosha\Support\Types\FixedPoint;

test('it can be created from float', function () {
    $fp = FixedPoint::fromFloat(1.234);
    expect($fp->value)->toBe(1234);
});

test('it converts back to float', function () {
    $fp = new FixedPoint(5500);
    expect($fp->toFloat())->toBe(5.5);
});

test('it can perform addition', function () {
    $a = FixedPoint::fromFloat(10.5);
    $b = FixedPoint::fromFloat(2.1);
    
    expect($a->add($b)->toFloat())->toBe(12.6);
});

test('it can perform subtraction', function () {
    $a = FixedPoint::fromFloat(10.0);
    $b = FixedPoint::fromFloat(3.5);
    
    expect($a->subtract($b)->toFloat())->toBe(6.5);
});

test('multiplication preserves scale', function () {
    $a = FixedPoint::fromFloat(2.5); // 2500
    $b = FixedPoint::fromFloat(4.0); // 4000
    
    // (2500 * 4000) / 1000 = 10000 -> 10.0
    expect($a->multiply($b)->toFloat())->toBe(10.0);
});

test('division preserves scale', function () {
    $a = FixedPoint::fromFloat(10.0);
    $b = FixedPoint::fromFloat(4.0);
    
    expect($a->divide($b)->toFloat())->toBe(2.5);
});

test('it throws exception on division by zero', function () {
    $a = FixedPoint::fromFloat(10.0);
    $b = new FixedPoint(0);
    
    expect(fn() => $a->divide($b))->toThrow(DivisionByZeroError::class);
});

test('it can compare values', function () {
    $a = FixedPoint::fromFloat(10.0);
    $b = FixedPoint::fromFloat(5.0);
    
    expect($a->isGreaterThan($b))->toBeTrue();
    expect($b->isLessThan($a))->toBeTrue();
});
