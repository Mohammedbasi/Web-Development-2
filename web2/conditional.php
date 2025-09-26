<?php

/**
 * if: 
 * if ... else 
 * if ... elseif ... else
 * switch:
 */

$age = 20;
$gender = 'female';

if ($age > 15 && $gender == 'male') {
    echo "Allowed";
}

if ($age > 15 && $gender == 'female') {
    echo 'You are in the right place!';
} else {
    echo 'Not Allowed';
}

echo "<br>";

$t = date("H");

echo $t;

echo "<br>";


if ($t < "10") {
    echo "Have a good morning!";
} elseif ($t < "20") {
    echo 'Have a good day!';
} else {
    echo "Have a good night!";
}


echo "<br>";


if ($t > "10") echo "Have a good morning!";

echo "<br>";

$msg = $t < "15" ? "Have a good morning!" : 'Have a good day!';

echo $msg;


echo "<br>";


$value = 35;

if ($value > 12) {
    echo 'Above 12';
    echo "<br>";

    if ($value > 20) {
        echo 'also Above 20';
    } else {
        echo 'but not Above 20';
    }
}



