<?php
require_once 'Database.php';
require_once 'StudentManager.php';
require_once 'Student.php';
require_once 'FormValidator.php';
require_once 'auth/Auth.php';

$auth = new Auth();
$auth->requireLogin();
$auth->requireTeacher();

$page_title = "Edit Students";
$page_description = "Edit Students Description";
$active_page = "edit_student";

$studentManager = new StudentManager();
$database = Database::getInstance();

// get student id
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$student = $studentManager->getStudentById($id);

if (!$student) {
    header("location: view_students.php");
    exit();
}

// Initialize variables
$name   = $student->getName();
$email  = $student->getEmail();
$phone  = $student->getPhone();
$course = $student->getCourse();
$grade  = $student->getGrade();
$photo  = $student->getPhoto();

$name_err = $email_err = $course_err = "";

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validator = new FormValidator($_POST);

    $validator->validateRequired('name', 'Please enter a name')
        ->validateRequired('email', 'Please enter an email')
        ->validateEmail('email', 'Invalid email format')
        ->validateRequired('course', 'Please select a course');

    $name   = FormValidator::sanitizeInput($_POST["name"]);
    $email  = FormValidator::sanitizeInput($_POST["email"]);
    $phone  = FormValidator::sanitizeInput($_POST["phone"]);
    $course = FormValidator::sanitizeInput($_POST["course"]);
    $grade  = FormValidator::sanitizeInput($_POST["grade"]);

    // Handle photo upload if a new one is selected
    if (!empty($_FILES["photo"]["name"])) {
        $target_dir  = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $file_name   = time() . "_" . basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $file_name;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($imageFileType, $allowed)) {
            $photo_err = "Only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif ($_FILES["photo"]["size"] > 2000000) {
            $photo_err = "File is too large. Maximum 2MB.";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // delete old photo if exists
                if ($student->getPhoto() && file_exists("uploads/" . $student->getPhoto())) {
                    unlink("uploads/" . $student->getPhoto());
                }
                $photo = $file_name;
            }
        }
    }

    if ($studentManager->emailExists($email, $id)) {
        $email_err = "This email is already registered.";
    }

    $errors = $validator->getErrors();
    if (!empty($errors)) {
        if (isset($errors['name']))   $name_err = $errors['name'];
        if (isset($errors['email']))  $email_err = $errors['email'];
        if (isset($errors['course'])) $course_err = $errors['course'];
    }

    if (empty($name_err) && empty($email_err) && empty($course_err)) {
        $student->setName($name);
        $student->setEmail($email);
        $student->setPhone($phone);
        $student->setCourse($course);
        $student->setGrade($grade);
        $student->setPhoto($photo);

        if ($studentManager->updateStudent($student)) {
            header("location: view_students.php?update=success");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
    $database->close();
}

include 'header.php';
?>

<div class="card">
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Name -->
        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            <span class="help-block"><?php echo $name_err; ?></span>
        </div>

        <!-- Email -->
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>

        <!-- Phone -->
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
        </div>

        <!-- Course -->
        <div class="form-group <?php echo (!empty($course_err)) ? 'has-error' : ''; ?>">
            <label for="course">Course</label>
            <select id="course" name="course" required>
                <option value="">Select a course</option>
                <option value="Computer Science" <?php echo ($course == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                <option value="Business Administration" <?php echo ($course == 'Business Administration') ? 'selected' : ''; ?>>Business Administration</option>
                <option value="Engineering" <?php echo ($course == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                <option value="Medicine" <?php echo ($course == 'Medicine') ? 'selected' : ''; ?>>Medicine</option>
                <option value="Arts" <?php echo ($course == 'Arts') ? 'selected' : ''; ?>>Arts</option>
            </select>
            <span class="help-block"><?php echo $course_err; ?></span>
        </div>

        <!-- Grade -->
        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="number" id="grade" name="grade" min="0" max="100" step="0.01" value="<?php echo $grade; ?>">
        </div>

        <!-- Photo -->
        <div class="form-group">
            <label for="photo">Profile Photo</label><br>
            <?php if ($photo): ?>
                <img src="uploads/<?php echo $photo; ?>" alt="Profile Photo" width="100"><br>
            <?php endif; ?>
            <input type="file" id="photo" name="photo" accept="image/*">
        </div>

        <!-- Buttons -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Student</button>
            <a href="view_students.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
</div>
</body>

</html>