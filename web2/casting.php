<?php

// (string) // to string
// (int) // to integer
// (float) // to float
// (bool) // to boolean (true or false)
// (array) // to array
// (object) // to object
// (unset) // to NULL

$a = 10;
$b = 10.12;
$c = "mohammed";
$d = true;
$e = null;

$b = (string) $b;
$d = (string) $d;

var_dump($b);
var_dump($d);

$b = (int) $b;
$d = (int) $d;

var_dump($b);
var_dump($d);

$c = "25 KM";
$c = "KM 25";
$c = (int) $c;
var_dump($c);

$e = (int)$e;
var_dump($e);

$b = (float) $b;
$d = (float) $d;
var_dump($b);
var_dump($d);

$c = "25 KM";
$c = "KM 25";
$c = (float) $c;
var_dump($c);

$a = 10;
$b = 5.63;
$c = 0;
$d = -1;
$e = 0.1;
$f = 'Gaza';
$g = "";
$h = true;
$i = null;

$a = (bool) $a;
var_dump($a);

$c = (bool) $c;
var_dump($c);

$a = 10;

$a = (array) $a;
$i = (array) $i;
var_dump($a);
var_dump($i);


class Car
{
    public $color;
    public $model;

    public function __construct($color, $model)
    {
        $this->color = $color;
        $this->model = $model;
    }

    public function message()
    {
        return "My car is a " . $this->color . " " . $this->model . "!";
    }
}

$myCar = new Car("red", "BMW");

$myCar = (array) $myCar;
var_dump($myCar);

$a = 5;

$a = (object) $a;
var_dump($a);
unset($a);
