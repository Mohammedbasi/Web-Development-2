<?php

$student = [
    "id" => 101,
    "name" => "Ali",
    "grade" => "A",
];
?>

<h3>Student Info</h3>

<ul>
    <?php foreach ($student as $key => $value): ?>
        <li><b> <?= ucfirst($key) ?> : </b> <?= $value ?> </li>

    <?php endforeach; ?>
</ul>

<?php

// add
$student["email"] = "mohammed@gmail.com";

// update
$student["grade"] = "B";

// delete

unset($student["name"]);
?>

<h3>Updated Student Info</h3>
<ul>
    <?php foreach ($student as $key => $value): ?>
        <li><b> <?= ucfirst($key) ?> : </b> <?= $value ?> </li>

    <?php endforeach; ?>
</ul>

<?php

$scores = [
    "Ali" => 80,
    "Mohammed" => 90,
    "Omar" => 95
];

arsort($scores);

?>

<h3>Student Scores (Descending)</h3>

<table border="1">
    <tr>
        <th>Student</th>
        <th>Score</th>
    </tr>

    <?php foreach ($scores as $name => $score): ?>
        <tr>
            <td><?= $name ?></td>
            <td><?= $score ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php

$students = [
    "S101" => ["name" => "Ali", "grade" => 80],
    "S102" => ["name" => "Mohammed", "grade" => 90],
    "S103" => ["name" => "Omar", "grade" => 95],
];

$students["S104"] = ["name" => "Khaled", "grade" => 70];

$students["S103"]["grade"] = 75;

unset($students['S102']);

krsort($students);
?>

<h3>Student Records</h3>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Grade</th>
    </tr>

    <?php foreach ($students as $id => $info): ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $info["name"] ?></td>
            <td><?= $info["grade"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>