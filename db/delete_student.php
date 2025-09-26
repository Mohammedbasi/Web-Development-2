<?php
require_once 'Database.php';
require_once 'StudentManager.php';
require_once 'Student.php';
require_once 'auth/Auth.php';

$auth = new Auth();
$auth->requireLogin();
$auth->requireAdmin();

$studentManager = new StudentManager();

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    $student = $studentManager->getStudentById($id);

    if ($student) {
        // delete photo file if exists
        if ($student->getPhoto() && file_exists("uploads/" . $student->getPhoto())) {
            unlink("uploads/" . $student->getPhoto());
        }

        if ($studentManager->deleteStudent($id)) {
            header("location: view_students.php?delete=success");
            exit();
        } else {
            header("location: view_students.php?delete=error");
            exit();
        }
    } else {
        header("location: view_students.php?delete=notfound");
        exit();
    }
} else {
    header("location: view_students.php");
    exit();
}
