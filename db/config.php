<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'student_management');

// DB connection
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// create DB
$create_db_sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (mysqli_query($conn, $create_db_sql)) {
    // select DB
    mysqli_select_db($conn, DB_NAME);

    // create students table
    $create_table_sql = "CREATE TABLE IF NOT EXISTS students (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20),
        course VARCHAR(50) NOT NULL,
        grade DECIMAL(4,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (!mysqli_query($conn, $create_table_sql)) {
        die("ERROR: Could not create table. " . mysqli_error($conn));
    }
} else {
    die("ERROR: Could not create database. " . mysqli_error($conn));
}

//Function to test user inputs

function sanitize_input($data)
{
    global $conn;

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// start session
session_start();
