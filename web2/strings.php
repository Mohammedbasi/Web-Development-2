<?php

$name = "Mohammed";

echo "Hello $name";
echo 'Hello $name' . '<br>';

echo strlen("Hello, Gaza!!") . "<br>";

echo str_word_count("Hello, Gaza!!")  . "<br>";

echo strpos("Hello Gaza", "Gaza")  . "<br>";


echo strtoupper($name) . "<br>";
echo strtolower($name) . "<br>";

$msg = "Hello World!";

echo $msg . '<br>';
echo str_replace("World", "Gaza", $msg) . "<br>";
echo strrev($msg) . "<br>";
echo trim($msg) . "<br>";

$msg2 = explode(" ", $msg);
print_r($msg2);

$myName = "Mohammed";
$myAge = "24";

// $me = "My name is " . $myName . " and my age is " . $myAge;
$me = "My name is $myName and my age is $myAge";
echo  "<br>" .  $me . "<br>";

echo substr($msg, 6, 5) . '<br>';
echo substr($msg, 6) . '<br>';
echo substr($msg, -5, 3) . '<br>';

$myName = "My\t name is \"MOhammed\"";
$myName = 'My name is \'Mohammed\'';
echo $myName;
