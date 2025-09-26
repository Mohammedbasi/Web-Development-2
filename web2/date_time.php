<?php

date_default_timezone_set("Asia/Gaza");

/**
 * d: day (01 -> 31)
 * m: month (01 -> 12)
 * Y: year (in 4 digits)
 * l: day of the week
 * 
 * /, ., - 
 */

echo "Today is " . date("Y/m/d") . "<br>";

echo "Today is " . date("Y.m.d") . "<br>";

echo "Today is " . date("Y-m-d") . "<br>";

echo "Today is " . date("l") . "<br>";
?>

&copy; 2015-<?php echo date("Y"); ?>


<?php
echo "<br>";

/**
 * H: 24-hour format (00 -> 23)
 * h: 12-hour format (01 -> 12)
 * i: minutes (00 -> 59)
 * s: seconds (00 -> 59)
 * a: am, pm 
 */

echo "The time is " . date("h:i:sa");

echo "<br>";

echo "ـــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ";

echo "<br>";

/**
 * Unix timestam: number of seconds between the unix epoch (1 1 1970 00:00:00)
 * 
 */

$d = mktime(10, 30, 40, 7, 20, 2025);
echo "Created date is " . date("Y-m-d h:i:sa", $d);

echo "<br>";

$d = strtotime("9:40pm September 4 2024");

echo "Created date is " . date("Y-m-d h:i:sa", $d);

echo "<br>";

$d = strtotime("tomorrow");
echo "Created date is " . date("Y-m-d h:i:sa", $d);

echo "<br>";


$d = strtotime("next Monday");
echo "Created date is " . date("Y-m-d h:i:sa", $d);

echo "<br>";


$d = strtotime("+4 Months");
echo "Created date is " . date("Y-m-d h:i:sa", $d);

echo "<br>";

echo "ـــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ";

echo "<br>";

$startDate = strtotime("Sunday");
$endDate = strtotime("+5 weeks", baseTimestamp: $startDate);

while ($startDate < $endDate) {
    echo date("M d", $startDate) . "<br>";

    $startDate = strtotime("+1 week", $startDate);
}

echo "<br>";


$date1 = strtotime("September 20");
$date2 = ceil(($date1 - time()) / 60 / 60 / 24);

echo "There are " . $date2 . " days until 20 September";
