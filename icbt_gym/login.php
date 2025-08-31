<?php
// Start session
session_start();

// Include config file
require_once "config.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username and password are empty
    if(empty(trim($_POST["username"])) || empty(trim($_POST["password"]))){
        $login_err = "Please enter username and password.";
    } else{
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        
        // Prepare a select statement
        $sql = "SELECT id, email, password, role FROM users WHERE student_id = ? OR email = ?";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ss", $param_username, $param_username);
            $param_username = $username;
            
            if($stmt->execute()){
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    $stmt->bind_result($id, $email, $hashed_password, $role);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = $role;
                            
                            // Redirect user to dashboard page
                            header("location: dashboard.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
  <title>Login - ICBT Gym</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Member Login</h2>
    <?php 
    if(!empty($login_err)){
        echo '<div class="alert-error">' . $login_err . '</div>';
    }        
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <label for="username">Student ID / Email</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <button type="submit" class="btn">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>