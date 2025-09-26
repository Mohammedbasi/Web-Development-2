<?php

function myMessage()
{
    return 'hello';
}

$myArr = array("Gaza", 20, ['Mohammed', 'Ahmed'], myMessage());

echo count($myArr) . "<br>";

$names = array('Mohammed', 'Ahmed', 'Sami', 'Khaled');

echo $names[2] . "<br>";

$names[2] = 'Raed';

echo $names[2] . "<br>";

foreach ($names as $name) {
    echo "$name <br>";
}

echo '********************************************' . '<br>';

for ($i = 0; $i < count($names); $i++) {
    echo "$names[$i] <br>";
}

echo '********************************************' . '<br>';

array_push($names, "Hani");

var_dump($names);

$cars = [];

$cars[5] = "Volvo";
$cars[7] = 'Ford';
$cars[14] = "BMW";

array_push($cars, "Toyota");
var_dump($cars);
