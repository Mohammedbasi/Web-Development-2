<?php
if (session_status() === "PHP_SESSION_NONE") {
    session_start();
}

$page_title = isset($page_title) ? $page_title : 'Student Management System';
$page_description = isset($page_description) ? $page_description : "Manage student records";
$active_page = isset($active_page) ? $active_page : 'dashboard';
$style_path = isset($style_path) ? $style_path : 'style.css';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?></title>
    <link rel="stylesheet" href="<?php echo $style_path ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Student Manager</h2>
        </div>
        <ul class="nav-links">
            <?php if ($auth->isLoggedIn()) : ?>
                <li><a href="index.php" class="<?php echo $active_page == 'dashboard' ? 'active' : ''; ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="view_students.php" class="<?php echo $active_page == 'view_students' ? 'active' : ''; ?>"><i class="fas fa-users"></i> View Students</a></li>

                <?php if ($auth->isAdmin() || $auth->isTeacher()): ?>
                    <li><a href="add_student.php" class="<?php echo $active_page == 'add_student' ? 'active' : ''; ?>"><i class="fas fa-user-plus"></i> Add Student</a></li>
                <?php endif; ?>


                <li><a href="search_student.php" class="<?php echo $active_page == 'search_students' ? 'active' : ''; ?>"><i class="fas fa-search"></i> Search Student</a></li>
                <li><a href="reports.php" class="<?php echo $active_page == 'reports' ? 'active' : ''; ?>"><i class="fas fa-chart-bar"></i> Reports</a></li>

                <?php if ($auth->isAdmin()): ?>
                    <li><a href="admin.php" class="<?php echo $active_page == 'admin' ? 'active' : ''; ?>">Admin</a></li>
                <?php endif; ?>
                <li class="nav-user">
                    <span>Welcome, <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role'] ?>)</span>
                    <a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </li>
            <?php else: ?>
                <li><a href="login.php" class="<?php echo $active_page == 'login' ? 'active' : '' ?>"><i class="fas fa-sign-in-alt"></i>Login</a></li>
                <li><a href="register.php" class="<?php echo $active_page == 'register' ? 'active' : '' ?>"><i class="fas fa-user-plus"></i>Register</a></li>

            <?php endif; ?>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1><?php echo $page_title ?></h1>
            <p><?php echo $page_description ?></p>
        </header>