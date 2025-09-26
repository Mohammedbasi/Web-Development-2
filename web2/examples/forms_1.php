<?php
// define variables
$name = $email = $password = $gender = $about = "";
$hobbies = [];

// error mgs
$nameErr = $emailErr = $passwordErr = $genderErr = $hobbiesErr = $aboutErr = "";

// function to clean input data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

// check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // name validation
    if (empty($_POST["name"])) {
        $nameErr = "Name is required!";
    } else {
        $name = test_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and spaces are allowed";
        }
    }

    // email validation
    if (empty($_POST['email'])) {
        $emailErr = "Email is required!";
    } else {
        $email = test_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    //password validation
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required!";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters";
        }
    }

    // gender validation
    if (empty($_POST['gender'])) {
        $genderErr = "Gender is required!";
    } else {
        $gender = test_input($_POST['gender']);
    }

    // hobbies validation
    if (empty($_POST['hobbies'])) {
        $hobbiesErr = "Please select at least one hobby";
    } else {
        $hobbies = $_POST['hobbies'];
    }

    // about validation
    if (empty($_POST['about'])) {
        $aboutErr = "Please write something about yourself";
    } else {
        $about = test_input($_POST['about']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        .error {
            color: red;
        }

        .container {
            max-width: 500px;
            margin: auto;
            font-family: Arial, Helvetica, sans-serif;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Student Registration Form</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            Name: <input type="text" name="name" value="<?php echo $name ?>">
            <span class="error"> <?php echo $nameErr; ?> </span><br><br>

            Email: <input type="text" name="email" value="<?php echo $email ?>">
            <span class="error"> <?php echo $emailErr; ?> </span><br><br>

            Password: <input type="password" name="password">
            <span class="error"> <?php echo $passwordErr; ?> </span><br><br>

            Gender:
            <input type="radio" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>> Male
            <input type="radio" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>> Female
            <br><span class="error"> <?php echo $genderErr; ?> </span><br><br>



            Hobbies: <br>
            <input type="checkbox" name="hobbies[]" value="Reading" <?php if (in_array("Reading", $hobbies)) echo "checked" ?>> Reading
            <input type="checkbox" name="hobbies[]" value="Sports" <?php if (in_array("Sports", $hobbies)) echo "checked" ?>> Sports
            <input type="checkbox" name="hobbies[]" value="Programming" <?php if (in_array("Programming", $hobbies)) echo "checked" ?>> Programming
            <br> <span class="error"> <?php echo $hobbiesErr; ?> </span><br><br>


            About You: <br>
            <textarea name="about" rows="4"><?php echo $about ?></textarea>
            <span class="error"> <?php echo $aboutErr; ?> </span><br><br>

            <input type="submit" value="Register">
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"
            && empty($nameErr) && empty($emailErr) && empty($passwordErr)
            && empty($genderErr) && empty($hobbiesErr) && empty($aboutErr)
            ){
                echo "<h3>Registration Successful</h3>";
                echo "<strong>Name:</strong> $name <br>";
                echo "<strong>Email:</strong> $email <br>";
                echo "<strong>Gender:</strong> $gender <br>";
                echo "<strong>Hobbies:</strong> " . implode(", ", $hobbies) . "<br>";
                echo "<strong>About:</strong> $about <br>";
            }
        ?>
    </div>

</body>

</html>