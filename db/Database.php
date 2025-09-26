<?php

class Database
{
    private static $instance = null;
    private $connection;

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'student_management';

    private function __construct()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password);

        if (!$this->connection) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $this->createDatabase();

        mysqli_select_db($this->connection, $this->dbname);

        $this->createTables();
    }

    private function __clone() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
    private function createDatabase()
    {
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname;
        if (!mysqli_query($this->connection, $sql)) {
            die("ERROR: Could not create database. " . mysqli_error($this->connection));
        }
    }

    private function createTables()
    {
        $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20),
        course VARCHAR(50) NOT NULL,
        grade DECIMAL(4,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

        if (!mysqli_query($this->connection, $sql)) {
            die("ERROR: Could not create table. " . mysqli_error($this->connection));
        }

        $sql = "CREATE TABLE IF NOT EXISTS users(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'teacher', 'student') DEFAULT 'student',
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (!mysqli_query($this->connection, $sql)) {
            die("ERROR: Could not create table. " . mysqli_error($this->connection));
        }
    }

    public function sanitize($data)
    {
        return mysqli_real_escape_string($this->connection, htmlspecialchars(trim($data)));
    }

    public function close()
    {
        mysqli_close($this->connection);
    }
}
