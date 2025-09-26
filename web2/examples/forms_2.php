<?php
$name = $email = $subject = $priority = $message = "";
$contactMethod = "";
$subscribe = "";

$nameErr = $emailErr = $subjectErr = $priorityErr = $messageErr = $contactMethodErr = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['name'])) {
        $nameErr = "Name is required!";
    } else {
        $name = test_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters ans spaces allowed!";
        }
    }

    if (empty($_POST['email'])) {
        $emailErr = "Email is required!";
    } else {
        $email = test_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST['subject'])) {
        $subjectErr = "Subject is required!";
    } else {
        $subject = test_input($_POST['subject']);
    }

    if (empty($_POST['priority'])) {
        $priorityErr = "Please select priority";
    } else {
        $priority = test_input($_POST['priority']);
    }

    if (empty($_POST['contactMethod'])) {
        $contactMethodErr = "Please select a contact method";
    } else {
        $contactMethod = test_input($_POST['contactMethod']);
    }

    if (empty($_POST['message'])) {
        $messageErr = "Message cannot be empty!";
    } else {
        $message = test_input($_POST['message']);
    }

    if (!empty($_POST['subscribe'])) {
        $subscribe = "Yes";
    } else {
        $subscribe = "No";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact/Feedback Form</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type=text],
        input[type=email],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 6px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type=submit] {
            background: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background: #45a049;
        }

        .error {
            color: red;
            font: 0.9em;
        }

        .result {
            background: #e2ffe2;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .checkbox-group,
        .radio-group {
            margin: 10px 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Contact / Feedback Form</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

            <!-- Name -->
            <div class="form-group">
                Name:
                <input type="text" name="name" value="<?php echo $name ?>">
                <span class="error"> <?php echo $nameErr ?> </span>
            </div>

            <!-- Email -->
            <div class="form-group">
                Email:
                <input type="email" name="email" value="<?php echo $email ?>">
                <span class="error"> <?php echo $emailErr ?> </span>
            </div>

            <!-- Subject -->
            <div class="form-group">
                Subject:
                <input type="text" name="subject" value="<?php echo $subject ?>">
                <span class="error"> <?php echo $subjectErr ?> </span>
            </div>

            <div class="form-group">
                Priority:
                <select name="priority">
                    <option value="Low" <?php if ($priority == "Low") echo "selected"; ?>>Low</option>
                    <option value="Medium" <?php if ($priority == "Medium") echo "selected"; ?>>Medium</option>
                    <option value="High" <?php if ($priority == "High") echo "selected"; ?>>High</option>

                </select>
                <span class="error"> <?php echo $priorityErr ?> </span>
            </div>

            <div class="form-group radio-group">
                Preferred Contact Method:
                <input type="radio" name="contactMethod" value="Email" <?php if ($contactMethod == "Email") echo "checked"; ?>> Email
                <input type="radio" name="contactMethod" value="Phone" <?php if ($contactMethod == "Phone") echo "checked"; ?>> Phone
                <span class="error"> <?php echo $contactMethodErr ?> </span>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" name="subscribe" <?php if ($subscribe == "Yes") echo "checked"; ?>> Subscribe to newsletter
            </div>

            <div class="form-group">
                Message:
                <textarea name="message" rows="5"> <?php echo $message ?> </textarea>
                <span class="error"><?php echo $messageErr ?></span>
            </div>

            <input type="submit" value="Send Feedback">
        </form>

        <?php
        if (
            $_SERVER["REQUEST_METHOD"] == "POST" &&
            empty($nameErr) && empty($emailErr) && empty($subjectErr)
            && empty($priorityErr) && empty($contactMethodErr) && empty($messageErr)
        ) {

            echo "<div class='result'>";
            echo  "<h3>Feedback Submitted Successfully!</h3>";
            echo "<strong>Name:</strong> $name <br>";
            echo "<strong>Email:</strong> $email <br>";
            echo "<strong>Subject:</strong> $subject <br>";
            echo "<strong>Priority:</strong> $priority <br>";
            echo "<strong>Preferred Contact:</strong> $contactMethod <br>";
            echo "<strong>Subscribed:</strong> $subscribe <br>";
            echo "<strong>Message:</strong> $message <br>";
            echo "</div>";
        }
        ?>
    </div>
</body>

</html>