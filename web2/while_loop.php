<?php

$i = 0;

while ($i < 6) {
    // if ($i == 3) break;

    $i++;
    if ($i == 3) continue;
    echo $i . ' ';
}

echo "<br>";

// while ($i < 6) :
//     // if ($i == 3) break;

//     $i++;
//     if ($i == 3) continue;
//     echo $i . ' ';

// endwhile;

$i = 1;

while ($i <= 10) {

    if ($i % 2 == 0) {
        echo $i . ' Is Even Number';
        echo "<br>";
    } else {
        echo $i . ' Is Odd Number';
        echo "<br>";
    }

    $i++;
}
