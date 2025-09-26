<?php
require_once 'Database.php';
require_once 'Student.php';
require_once 'StudentManager.php';
require_once 'auth/Auth.php';

$auth = new Auth();

$auth->requireLogin();
$auth->requireTeacher();
// Create StudentManager instance
$studentManager = new StudentManager();

// Get statistics and course data
$stats = $studentManager->getStatistics();
$students_by_course = $studentManager->getStudentsByCourse();

include 'header.php';
?>



<div class="card">
    <h2><i class="fas fa-chart-pie"></i> Student Statistics</h2>
    <div class="dashboard-cards">
        <div class="card stat-card">
            <i class="fas fa-users"></i>
            <h3><?php echo $stats['total_students']; ?></h3>
            <p>Total Students</p>
        </div>
        <div class="card stat-card">
            <i class="fas fa-book"></i>
            <h3><?php echo count($stats['courses']); ?></h3>
            <p>Courses</p>
        </div>
        <div class="card stat-card">
            <i class="fas fa-chart-line"></i>
            <h3><?php echo $stats['avg_grade']; ?></h3>
            <p>Average Grade</p>
        </div>
    </div>
</div>

<div class="card">
    <h2><i class="fas fa-graduation-cap"></i> Students by Course</h2>
    <table>
        <thead>
            <tr>
                <th>Course</th>
                <th>Number of Students</th>
                <th>Average Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students_by_course as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['course']); ?></td>
                    <td><?php echo $course['count']; ?></td>
                    <td><?php echo number_format($course['avg_grade'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h2><i class="fas fa-download"></i> Export Reports</h2>
    <div class="action-buttons">
        <button class="btn btn-primary"><i class="fas fa-file-pdf"></i> Export as PDF</button>
        <button class="btn btn-success"><i class="fas fa-file-excel"></i> Export as Excel</button>
        <button class="btn btn-secondary"><i class="fas fa-file-csv"></i> Export as CSV</button>
    </div>
</div>
</div>
</body>

</html>