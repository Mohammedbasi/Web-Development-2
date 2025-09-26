<?php

/** Arithmetic */
$x = 10;
$y = 5;

$c = $x + $y;
$c = $x - $y;
$c = $x * $y;
$c = $x / $y;
$c = $x % $y;

echo $c;

echo "<br>";

$c = $x ** $y;

echo $c;

echo "<br>";



/** Assignment */
$x = 10;
$y = 5;

$x += $y; // $x = $x + $y

echo $x;
echo "<br>";

$x -= $y; // $x = $x - $y

echo $x;

$x *= $y; // $x = $x * $y;

$x /= $y;

$x %= $y;
echo "<br>";



/** comparison */

$x = 9;
$y = 8;
$z = 20;

echo $x == $y; // blank
var_dump($x == $y);
var_dump($x === $y);
var_dump($x != $y);
var_dump($x <> $z);

var_dump($x !== $y); // not identical

var_dump($x > $y);
var_dump($x < $y);
var_dump($x >= $y);
var_dump($x <= $y);

var_dump($x <=> $y);

$x = 10;
$y = 5;

echo $x++;

echo "<br>";

echo $x; //$x = 11
echo "<br>";

echo ++$x;

echo "<br>";

/** logical */

$x = 10; //true
$y = 0;

echo $x and $y;

var_dump($x and $y);
var_dump($x or $y);
var_dump($x && $y);
var_dump($x || $y);
var_dump(!$x);

echo "<br>";

/** string */

$x = 'Mohammed';
$y = 'Ahmed';

// $z = $x . ' ' . $y;

// echo $z;
$x .= ' ';
$x .= $y;

echo $x;

echo "<br>";

/** conditional assignment */

// $x = expr1 ? expr2 : expr 3;

$x = 10;
$y = 0;

$z = $y ? 'mohammed' : 'ahmed';

echo $z;

echo "<br>";

// $x = expr1 ?? expr2;

$x = null;
$y = 50;

$z = $x ?? $y;

echo $z;
