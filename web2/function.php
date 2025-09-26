<?php

declare(strict_types=1);

/**
 * function: block of code< , that can be used repeatedly in a program
 */

function message()
{
    echo 'Hello Gaza';
}

message();

echo "<br>";

function fullName($fname, $lname, $email = 'test@example.com')
{

    echo "$fname $lname $email";
    echo "<br>";
}

fullName('Mohammed', 'Basil', 'mohammed@gmail.com');
fullName('Ahmed', 'Sami');

function setWidth($minWidth = 50)
{
    echo "The width is: $minWidth <br>";
}

setWidth(100);
setWidth(30);
setWidth();

function finalSalary($salary, $tax = 0.3)
{
    $finalSalary = $salary * (1 - $tax);
    return $finalSalary;
}

$salary = finalSalary(7000, 0.4);
echo $salary . "<br>";



function addTen(&$value)
{
    $value += 10;
}

$num = 5;
addTen($num); // passing by value: copy of the value

echo $num . "<br>";

function multiplyMyNums(...$x)
{
    $n = 1;
    $len = count($x);

    for ($i = 0; $i < $len; $i++) {
        $n *= $x[$i];
    }

    return $n;
}

$result = multiplyMyNums(5, 10, 1, 2);
$result = multiplyMyNums(1, 2, 3, 4, 5, 6, 7, 8);

echo $result . "<br>";

function myFamily($lastName, ...$firstName)
{

    $txt = "";
    $len = count($firstName);

    for ($i = 0; $i < $len; $i++) {
        $txt = $txt . "Hi, $firstName[$i] $lastName.<br>";
    }

    return $txt;
}

$result = myFamily('Zuqlam', 'mohammed', 'ahmed', 'sami', 'omar');
echo $result;

function addNumbers(float $a, float $b): int
{
    return (int)($a + $b);
}

// echo addNumbers(5, "5 days");
// echo addNumbers(5, 5);
echo addNumbers(5.3, 6.4);
