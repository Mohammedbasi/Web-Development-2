<?php

/**
 * for (expr1; expr2; expr3){
 *      code block
 * }
 * 
 * expr1: initialization statement
 * expr2: condition statement
 * expr3: update statement
 */

for ($i = 0; $i <= 200; $i += 20) {
    // if ($i == 5) break;
    // if ($i == 7) continue;
    echo "The number is: $i <br>";
}


echo "<br>";

for ($i = 0; $i <= 20; $i++) {
    if ($i % 2 == 0) {
        echo "$i Is Even Number";
        echo "<br>";
    } else {
        echo "$i Is Odd Number";
        echo "<br>";
    }
}
