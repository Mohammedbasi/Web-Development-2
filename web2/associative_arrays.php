<?php

$person = array("fname" => "Mohammed", "lname" => "Basil", "age" => 24);
var_dump($person);

echo $person["fname"] . " " . $person["lname"] . "<br>";

$person["age"] = 20;

echo $person['age'];

var_dump($person);

// $car = array("brand" => "BMW", "model" => "X6", "year" => 2010);

$car = [
    "brand" => "BMW",
    "model" => "X6",
    "year" => 2010, // trailing comma
];

foreach ($car as $key => $value) {
    echo "$key: $value <br>";
}


$cars = [
    0 => "Vlovo",
    1 => "BMW",
    2 => "Ford",
];

var_dump($cars);

$cars = [];

$cars[0] = "BMW";
$cars[1] = "Ford";
$cars[2] = "Toyota";

$myArr = [];

$myArr[0] = "Mohammed";
$myArr[1] = "Ahmed";
$myArr['name'] = "Khaled";

var_dump($myArr);   
