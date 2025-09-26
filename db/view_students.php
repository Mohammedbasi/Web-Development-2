<?php
require_once 'Database.php';
require_once 'Student.php';
require_once 'StudentManager.php';
require_once 'auth/Auth.php';

$auth = new Auth();

$auth->requireLogin();

$page_title = "View Students";
$page_description = "View Students Description";
$active_page = "view_students";
// Create StudentManager instance

/*
1- current page
2- per page: number of recored per page

limit: 
offset: (pageNumber - 1) * perPage 

total students:
total pages: 
*/
$studentManager = new StudentManager();

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 2;

if ($currentPage < 1) {
    $currentPage = 1;
}

$students = $studentManager->getPaginatedStudents($currentPage, $perPage);

$totalPages = $studentManager->getTotalPages($perPage);

if ($currentPage > $totalPages && $totalPages > 0) {
    $currentPage = $totalPages;
    header("location: view_students.php?page=" . $currentPage);
    exit();
}

include 'header.php';
?>



<?php if (isset($_GET['add']) && $_GET['add'] == 'success'): ?>
    <div class="alert alert-success">
        Student added successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
    <div class="alert alert-success">
        Student updated successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['delete']) && $_GET['delete'] == 'success'): ?>
    <div class="alert alert-success">
        Student deleted successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['delete']) && $_GET['delete'] == 'error'): ?>
    <div class="alert alert-danger">
        Error deleting student. Please try again.
    </div>
<?php endif; ?>

<?php if (isset($_GET['delete']) && $_GET['delete'] == 'notfound'): ?>
    <div class="alert alert-danger">
        Student not found.
    </div>
<?php endif; ?>

<div class="card">
    <div class="table-header">
        <h2>Student Records</h2>
        <a href="add_student.php" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add New Student</a>
    </div>

    <?php if (count($students) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Grade</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>

                        <td><?php echo $student->getId(); ?></td>
                        <td>
                            <?php if ($student->getPhoto()): ?>
                                <img src="uploads/<?php echo htmlspecialchars($student->getPhoto()) ?>"
                                    alt="Profile Photo"
                                    width="50"
                                    height="50"
                                    style="border-radius: 50%; object-fit:cover">
                            <?php else: ?>
                                <span>No Photo</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($student->getName()); ?></td>
                        <td><?php echo htmlspecialchars($student->getEmail()); ?></td>
                        <td><?php echo htmlspecialchars($student->getPhone()); ?></td>
                        <td><?php echo htmlspecialchars($student->getCourse()); ?></td>
                        <td><?php echo $student->getGrade() ? $student->getGrade() : 'N/A'; ?></td>
                        <td><?php echo date('M j, Y', strtotime($student->getCreatedAt())); ?></td>
                        <td class="action-buttons">
                            <a href="edit_student.php?id=<?php echo $student->getId(); ?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete_student.php?id=<?php echo $student->getId(); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="pagination">

            <?php if ($currentPage > 1): ?>
                <a href="view_students.php?page=1" class="btn btn-secondary"><i class="fas fa-angle-double-left"></i> First</a>
                <a href="view_students.php?page=<?php echo $currentPage - 1 ?>" class="btn btn-secondary"><i class="fas fa-angle-left"></i> Previous</a>
            <?php endif; ?>

            <span class="page-info"> Page <?php echo $currentPage ?> of <?php echo $totalPages ?></span>

            <?php if ($currentPage < $totalPages): ?>
                <a href="view_students.php?page=<?php echo $currentPage + 1 ?>" class="btn btn-secondary">Next <i class="fas fa-angle-right"></i></a>
                <a href="view_students.php?page=<?php echo $totalPages; ?>" class="btn btn-secondary">Last <i class="fas fa-angle-double-right"></i></a>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <p>No students found. <a href="add_student.php">Add your first student</a>.</p>
    <?php endif; ?>
</div>
</div>
</body>

</html>