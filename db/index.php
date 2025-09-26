<?php
require_once 'Database.php';
require_once 'StudentManager.php';
require_once 'Student.php';
require_once 'auth/Auth.php';

$auth = new Auth();

$auth->requireLogin();

// require_once "config.php";
// $total_students = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
// $total_students = mysqli_fetch_assoc($total_students)['total'];

// $avg_grade = mysqli_query($conn, "SELECT AVG(grade) as avg_grade FROM students WHERE grade IS NOT NULL");
// $avg_grade = mysqli_fetch_assoc($avg_grade)['avg_grade'];
// $avg_grade = number_format($avg_grade, 2);

// $recent_students = mysqli_query($conn, "SELECT * FROM students ORDER BY created_at DESC LIMIT 5");
$studentManager = new StudentManager();

$stats = $studentManager->getStatistics();
$recentStudents = $studentManager->getRecentStudents(5);

include 'header.php'
?>

<div class="dashboard-cards">
    <div class="card stat-card">
        <i class="fas fa-users"></i>
        <h3><?php echo $stats['total_students'] ?></h3>
        <p>Total Students</p>
    </div>
    <div class="card stat-card">
        <i class="fas fa-book"></i>
        <h3> <?php echo count($stats['courses']) ?> </h3>
        <p>Courses</p>
    </div>
    <div class="card stat-card">
        <i class="fas fa-chart-line"></i>
        <h3><?php echo $stats['avg_grade'] ?></h3>
        <p>Average Grade</p>
    </div>
    <div class="card stat-card">
        <i class="fas fa-user-graduate"></i>
        <h3>42</h3>
        <p>Graduates</p>
    </div>
</div>

<?php if ($auth->isAdmin() || $auth->isTeacher()): ?>
    <div class="card">
        <h2><i class="fas fa-history"></i> Recently Added Students</h2>

        <?php if (count($recentStudents) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentStudents as $student): ?>
                        <tr>
                            <td><?php echo $student->getId(); ?></td>
                            <td><?php echo htmlspecialchars($student->getName()) ?></td>
                            <td><?php echo htmlspecialchars($student->getEmail()) ?></td>
                            <td><?php echo htmlspecialchars($student->getCourse()) ?></td>
                            <td><?php echo $student->getGrade() ? $student->getGrade() : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students found. <a href="add_student.php">Add your first student</a>.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="card">
    <h2><i class="fas fa-tasks"></i> Quick Actions</h2>
    <div class="action-buttons">
        <a href="add_student.php" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add New Student</a>
        <a href="view_students.php" class="btn btn-secondary"><i class="fas fa-users"></i> View All Students</a>
        <a href="#" class="btn btn-success"><i class="fas fa-file-export"></i> Generate Report</a>
    </div>
</div>
</div>
</body>

</html>

<?php
$db = Database::getInstance();
$db->close();
?>