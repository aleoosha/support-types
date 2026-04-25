# Support Types

Fundamental value objects for the Hive-mind ecosystem.

## Installation
`composer require aleoosha/support-types`

## Usage (FixedPoint)
```php
use Aleoosha\Support\Types\FixedPoint;

$price = FixedPoint::fromFloat(10.50);
$tax = FixedPoint::fromFloat(1.20);

$total = $price->add($tax);
echo $total->toFloat(); // 11.7
```