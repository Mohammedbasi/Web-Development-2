<?php

define("AGE", 24); // case sensitive;

// define("NUM_OF_PAGE", 5, true); // case in-sensitive;


function age()
{
    echo "My Age Is: " . AGE;
    echo "<br>";
    echo __FUNCTION__;
    echo "<br>";
}

age();

const MYNAME = "Mohammed";

echo MYNAME;
echo "<br>";

define("names", [
    "Mohammed",
    "Ahmed",
    "Sami"
]);

echo __DIR__;
echo "<br>";

echo __FILE__;
echo "<br>";

echo __LINE__;
