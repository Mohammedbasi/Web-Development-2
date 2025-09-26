<?php

// Variable scope: the part pf script where the variable can be used

/**
 * 1- local
 * 2- global
 * 3- static
 */

$x = 10; // global scope

function test()
{
    $y = 'Ahmed'; // local scope;
    // echo "<p> Variable x inside function is: $x </p>"; will produce error
    echo "<p> Variable y inside function is: $y </p>";
}

function test2()
{
    $y = 'Ahmed'; // local scope;
    // echo "<p> Variable x inside function is: $x </p>"; will produce error
    echo "<p> Variable y inside function is: $y </p>";
}

test();
// echo "<p> Variable y outside function is: $y </p>"; will produce error
echo "<p> Variable x outside function is: $x </p>";

//*************************************************************************** */

$a = 20; // global scope
$b = 30; // global scope

function test3()
{
    // global $a, $b;

    // $b = $a + $b;

    $GLOBALS['b'] = $GLOBALS['a'] + $GLOBALS['b'];
}

test3();
echo $b;
echo "\n";
echo $GLOBALS['b'] . "\n";


function test4()
{
    static $z = 0;

    echo $z;

    $z++;
}

test4();
test4();
test4();
