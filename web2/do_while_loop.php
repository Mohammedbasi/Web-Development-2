<?php

$i = 0;

do {
    $i++;
    // if ($i == 4) break;
    if ($i == 4) continue;
    echo $i;
    echo "<br>";
} while ($i < 6);

$i = 1;

do {
    if ($i % 2 == 0) {
        echo $i . ' Is Even';
        echo "<br>";
    } else {
        echo $i . ' Is Odd';
        echo "<br>";
    }
    $i++;
} while ($i <= 10);
