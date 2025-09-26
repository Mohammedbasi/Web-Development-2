<?php
require_once 'Database.php';
require_once 'StudentManager.php';
require_once 'Student.php';
require_once 'FormValidator.php';
require_once 'auth/Auth.php';

$auth = new Auth();

$auth->requireLogin();
$auth->requireTeacher();

$studentManager = new StudentManager();

$search_results = [];
$search_term = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $search_term = FormValidator::sanitizeInput($_POST['search_term']);

    if (!empty($search_term)) {
        $search_results = $studentManager->searchStudents($search_term);
    }
}

include 'header.php';
?>


<div class="card">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="search_term">Search Term</label>
            <input type="text" id="search_term" name="search_term" value="<?php echo $search_term; ?>" placeholder="Enter name, email, or course">
        </div>

        <div class="form-group">
            <button type="submit" name="search" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
        </div>
    </form>
</div>

<?php if (!empty($search_term)): ?>
    <div class="card">
        <h2>Search Results for "<?php echo htmlspecialchars($search_term); ?>"</h2>

        <?php if (count($search_results) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($search_results as $student): ?>
                        <tr>
                            <td><?php echo $student->getId(); ?></td>
                            <td><?php echo htmlspecialchars($student->getName()); ?></td>
                            <td><?php echo htmlspecialchars($student->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($student->getPhone()); ?></td>
                            <td><?php echo htmlspecialchars($student->getCourse()); ?></td>
                            <td><?php echo $student->getGrade() ? $student->getGrade() : 'N/A'; ?></td>
                            <td class="action-buttons">
                                <a href="edit_student.php?id=<?php echo $student->getId(); ?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                                <a href="delete_student.php?id=<?php echo $student->getId(); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students found matching your search.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
</div>
</body>

</html>