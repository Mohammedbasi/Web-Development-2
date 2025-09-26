<?php

$color = 'red';

switch ($color) {

    case "red":
        echo 'Your favorite color is red';
        break;
    case "blue":
        echo 'Your favorite color is blue';
        break;
    case "green":
        echo 'Your favorite color is green';
        break;
    default:
        echo 'Your favorite color is neither red, blue, nor green';
}

echo "<br>";
$day = 6;

switch ($day) {

    default:
        echo 'Looking forward to the weekend!';
        break;
    case 0:
        echo 'Today is Saturday';
        break;
    case 1:
        echo 'Today is Sunday';
        break;
    case 5:
    case 6:
        echo 'It is the weekend';
}
