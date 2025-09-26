<?php

$students = [
    ["id" => "S101", "name" => ["fname" => "Ali", "lname" => "Ahmed"], "grade" => 80],
    ["id" => "S102", "name" => ["fname" => "Mohammed", "lname" => "Basil"], "grade" => 70],
    ["id" => "S103", "name" => ["fname" => "Omar", "lname" => "Sami"], "grade" => 90],
];


$students[] = ["id" => "S104", "name" => ["fname" => "Khaled", "lname" => "Rami"], "grade" => 60];

$students[1]["name"]["fname"] = "Mohamed";

// unset($students[1]);

// $students = array_values($students);

$grades = array_column($students, "grade");
array_multisort($grades, SORT_DESC, $students);
?>

<h3>Student Records</h3>

<table border="1">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Grade</th>
    </tr>

    <?php foreach ($students as $student) : ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= $student['name']['fname'] ?></td>
            <td><?= $student['name']['lname'] ?></td>
            <td><?= $student['grade'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php

$matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
];
?>

<h3>Matrix (2D Array)</h3>

<table border="1" cellpadding="10">
    <?php foreach ($matrix as $row): ?>
        <tr>
            <?php foreach ($row as $value): ?>
                <td><?= $value ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>

</table>

<?php
$courses = [
    ["HTML", "Beginner", "20 hours"],
    ["CSS", "Intermediate", "25 hours"],
    ["PHP", "Advanced", "40 hours"],
];
?>

<h3>Courses</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Course</th>
        <th>Level</th>
        <th>Duration</th>
    </tr>

    <?php foreach ($courses as $course) : ?>
        <tr>
            <td><?= $course[0] ?></td>
            <td><?= $course[1] ?></td>
            <td><?= $course[2] ?></td>
            
        </tr>
    <?php endforeach; ?>    
</table>