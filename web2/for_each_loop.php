<?php

/** 
 * for each loop: used to loop through array items or object properities
 * 
 */


$names = array('Mohammed', 'Ahmed', 'Sami', 'Khaled');

foreach ($names as &$name) {
    if ($name == 'Ahmed') {
        $name = 'Hani';
    }
    echo "$name <br>";
}

var_dump($names);

$members = array("Mohammed" => 24, "Ahmed" => 30, 'Sami' => 50, "Khaled" => 20);

foreach ($members as $name => $age) {
    echo "Name is $name, age is $age <br>";
}


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

foreach ($myCar as $property => $value) {
    echo "$property: $value <br>";
}
