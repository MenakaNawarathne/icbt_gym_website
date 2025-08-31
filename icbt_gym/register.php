<?php
// Start session
session_start();

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$student_id = $email = $password = $confirm_password = $first_name = $last_name = $phone = "";
$student_id_err = $email_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate student_id
    if(empty(trim($_POST["student_id"]))){
        $student_id_err = "Please enter a student ID.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE student_id = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $param_student_id);
            $param_student_id = trim($_POST["student_id"]);
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $student_id_err = "This student ID is already taken.";
                } else{
                    $student_id = trim($_POST["student_id"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    // Validate first name
    if(empty(trim($_POST["first_name"]))){
        $first_name_err = "Please enter your first name.";
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if(empty(trim($_POST["last_name"]))){
        $last_name_err = "Please enter your last name.";
    } else{
        $last_name = trim($_POST["last_name"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($student_id_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($first_name_err) && empty($last_name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (student_id, email, password, first_name, last_name, phone) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ssssss", $param_student_id, $param_email, $param_password, $param_first_name, $param_last_name, $param_phone);
            
            // Set parameters
            $param_student_id = $student_id;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_phone = trim($_POST["phone"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ICBT Gym</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label>Student ID</label>
                <input type="text" name="student_id" value="<?php echo $student_id; ?>">
                <span class="error"><?php echo $student_id_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?php echo $first_name; ?>">
                <span class="error"><?php echo $first_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?php echo $last_name; ?>">
                <span class="error"><?php echo $last_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password">
                <span class="error"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>