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
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = $register_err = "";

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!$auth->validateCSRFToken($_POST["csrf_token"])) {
        $register_err = "Invalid form submission";
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before attempting registration
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($register_err)) {
        try {
            if ($auth->register($username, $email, $password)) {
                header("Location: login.php?registration=success");
                exit();
            } else {
                $register_err = "Something went wrong. Please try again later.";
            }
        } catch (Exception $e) {
            $register_err = $e->getMessage();
        }
    }
}

// Set page variables for header
$page_title = "Register";
$page_description = "Create a new account";
$active_page = "register";
$style_path = '../style.css';

// Include header
include '../header.php';
?>

<div class="card">
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>

    <?php
    if (!empty($register_err)) {
        echo '<div class="alert alert-danger">' . $register_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <input type="hidden" name="csrf_token" value="<?php echo $auth->generateCSRFToken() ?>">

        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</div>
</body>

</html>