<?php
require_once 'Database.php';
require_once 'StudentManager.php';
require_once 'Student.php';
require_once 'FormValidator.php';
require_once 'auth/Auth.php';

$auth = new Auth();
$auth->requireLogin();
$auth->requireTeacher();

$page_title = "Add Students";
$page_description = "Add Students Description";
$active_page = "add_student";

$studentManager = new StudentManager();
$database = Database::getInstance();

// Initialize variables
$name = $email = $phone = $course = $grade = "";
$name_err = $email_err = $course_err = $photo_err = "";

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $validator = new FormValidator($_POST);

    $validator->validateRequired('name', 'Please enter a name')
        ->validateRequired('email', 'Please enter an email')
        ->validateEmail('email', 'Invalid email format')
        ->validateRequired('course', 'Please select a course');

    $name = FormValidator::sanitizeInput($_POST["name"] ?? '');
    $email = FormValidator::sanitizeInput($_POST["email"] ?? '');
    $phone = FormValidator::sanitizeInput($_POST["phone"] ?? '');
    $course = FormValidator::sanitizeInput($_POST["course"] ?? '');
    $grade = FormValidator::sanitizeInput($_POST["grade"] ?? null);

    if ($studentManager->emailExists($email)) {
        $email_err = "This email is already registered.";
    }

    $errors = $validator->getErrors();
    if (!empty($errors)) {
        if (isset($errors['name'])) $name_err = $errors['name'];
        if (isset($errors['email'])) $email_err = $errors['email'];
        if (isset($errors['course'])) $course_err = $errors['course'];
    }

    // --- FILE UPLOAD HANDLING ---
    $photoFilename = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['photo'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $photo_err = "Upload error. Code: " . $file['error'];
        } else {
            $maxFileSize = 2 * 1024 * 1024; // 2 MB
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
            $originalName = $file['name'];
            $fileSize = $file['size'];
            $fileTmp = $file['tmp_name'];
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            // extension check
            if (!in_array($ext, $allowedExts)) {
                $photo_err = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
            } elseif ($fileSize > $maxFileSize) {
                $photo_err = "File is too large. Max: 2MB.";
            } else {
                // Check real image
                $imgInfo = @getimagesize($fileTmp);
                if ($imgInfo === false) {
                    $photo_err = "Uploaded file is not a valid image.";
                } else {
                    // safe name + folder
                    $newFileName = uniqid('student_', true) . "." . $ext;
                    $uploadDir = __DIR__ . '/uploads/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $destination = $uploadDir . $newFileName;
                    if (!move_uploaded_file($fileTmp, $destination)) {
                        $photo_err = "Failed to move uploaded file.";
                    } else {
                        $photoFilename = $newFileName;
                    }
                }
            }
        }
    }

    // Check input errors before inserting
    if (empty($name_err) && empty($email_err) && empty($course_err) && empty($photo_err)) {

        $student = new Student(null, $name, $email, $phone, $course, $grade);
        $student->setPhoto($photoFilename);

        if ($studentManager->addStudent($student)) {
            header("location: view_students.php?add=success");
            exit();
        } else {
            // cleanup uploaded file to avoid orphaned files
            if ($photoFilename) {
                $uploaded = __DIR__ . '/uploads/' . $photoFilename;
                if (file_exists($uploaded)) {
                    @unlink($uploaded);
                }
            }
            echo "Something went wrong. Please try again later.";
        }
    }

    $database->close();
}

include 'header.php';
?>

<div class="card">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <span class="help-block"><?php echo $name_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        </div>

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

        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="number" id="grade" name="grade" min="0" max="100" step="0.01" value="<?php echo htmlspecialchars($grade); ?>">
        </div>

        <div class="form-group">
            <label for="photo">Profile Photo (optional)</label>
            <input type="file" id="photo" name="photo" accept="image/*">
            <span class="help-block"><?php echo $photo_err; ?></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add Student</button>
            <button type="reset" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</button>
        </div>
    </form>
</div>
</div>
</body>

</html>