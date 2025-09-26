<?php
// Three types of numbers

/**
 * integer: numbers without decimal part (positive or negative)
 * float: numbers with decimal points
 * number strings
 */

/**
 * infinity
 * NaN
 */

$age = 24; // integer
$salary = 500.60; // float
$gpa = "80.7";

var_dump($age);
var_dump($salary);
var_dump($gpa);

$a = 4;
$b = 2.5;
$c = $a * $b; // 4 * 2.5 = 10

var_dump($c);

echo PHP_INT_MAX . "<br>";
echo PHP_INT_MIN . "<br>";
echo PHP_INT_SIZE . "<br>";

var_dump(is_int($a));
var_dump(is_int($b));

/************************************************************************* */

echo PHP_FLOAT_MAX . "<br>";
echo PHP_FLOAT_MIN . "<br>";

echo PHP_FLOAT_DIG . "<br>";

echo PHP_FLOAT_EPSILON . "<br>";

var_dump(is_float($c));

$x = 1.9e411;
var_dump(is_finite($x));
var_dump(is_infinite($x));
var_dump($x);

$x = acos(8);
var_dump($x);

$x = 1000;

var_dump(is_numeric($x));

$x = "1000";

var_dump(is_numeric($x));

$x = "Mohammed";

var_dump(is_numeric($x));

$x  = 1234.56; // float;

var_dump(($x));

$int_cast = (int)$x;
var_dump($int_cast);

$x = "1234.56";

var_dump($x);

$int_cast = (int) $x;
var_dump($int_cast);
