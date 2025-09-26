<?php

$age = 25;
$salary = 200.80;
var_dump($age);
var_dump($salary);
$name = "Mohammed";
$email = 'm@gmail.com';

var_dump($name);
var_dump($email);

$isExist = true;
var_dump($isExist);

$languages = array("HTML", "CSS", "JS", "PHP");
var_dump($languages);

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
var_dump($myCar);

$gaza = "Hello Gaza";
$gaza = null;

var_dump($gaza);

$var1 = 5;
$var1 = (string) $var1;
var_dump($var1);

// $var = "Ahmed";
// var_dump($var);