<?php
$fruits = ["Apple", "Banana", "Orange"];
?>

<h3>Fruit List</h3>

<ul>
    <!-- <?php
            foreach ($fruits as $fruit) {
                echo "<li>$fruit</li>";
            }
            ?> -->

    <?php foreach ($fruits as $fruit) : ?>
        <li> <?= $fruit ?> </li>
    <?php endforeach; ?>
</ul>

<?php
$fruits[] = "Mango";
$fruits[] = "Grapes";
?>

<h3>Updated Fruit List</h3>

<?php foreach ($fruits as $fruit) : ?>
    <li> <?= $fruit ?> </li>
<?php endforeach; ?>

<?php
$fruits[1] = "Strawbery";
?>

<h3>Updated Fruit List (After editing)</h3>

<?php foreach ($fruits as $fruit) : ?>
    <li> <?= $fruit ?> </li>
<?php endforeach; ?>

<?php
unset($fruits[2]);
$fruits = array_values($fruits);
?>

<h3>After Deletion</h3>

<?php foreach ($fruits as $fruit) : ?>
    <li> <?= $fruit ?> </li>
<?php endforeach; ?>

<?php

$grades = [85, 92, 70, 60, 45];
rsort($grades);

?>

<h3>Sorted Grades</h3>

<table border="1">
    <tr>
        <th>#</th>
        <th>Grade</th>
    </tr>

    <?php foreach ($grades as $i => $grade): ?>
        <tr>
            <td> <?= $i + 1 ?> </td>
            <td> <?= $grade ?></td>
        </tr>
    <?php endforeach; ?>
</table>