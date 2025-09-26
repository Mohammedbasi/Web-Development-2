<?php
require_once '../Database.php';
require_once 'User.php';
require_once 'Auth.php';

$auth = new Auth();


if ($auth->isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

// Initialize variables
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!$auth->validateCSRFToken($_POST['csrf_token'])) {
        $login_err = "Invalid form submission";
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username or email.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before attempting login
    if (empty($username_err) && empty($password_err) && empty($login_err)) {

        if ($auth->login($username, $password)) {
            header("Location: ../index.php");
            exit();
        } else {
            $login_err = "Invalid username or password";
        }
    }
}

// Set page variables for header
$page_title = "Login";
$page_description = "Login to Student Management System";
$active_page = "login";
$style_path = '../style.css';

// Include header
include '../header.php';
?>

<?php if (isset($_GET['registration']) && $_GET['registration'] == 'success'): ?>
    <div class="alert alert-success">
        User registered successfully!
    </div>
<?php endif; ?>

<div class="card">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>

    <?php
    if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $auth->generateCSRFToken(); ?>">

        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username or Email</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>

        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        <p>Forgot your password? <a href="forgot_password.php">Reset it here</a>.</p>
    </form>
</div>
</div>
</body>

</html>