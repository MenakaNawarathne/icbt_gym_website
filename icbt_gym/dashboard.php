<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";
?>

<!DOCTYPE html>

<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Dashboard - ICBT Gym</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ICBT Kandy Campus Gym</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="plan.php">Plan</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to your dashboard.</h1>
        <p>
            <a href="progress.php" class="btn">Track Your Progress</a>
            <a href="booking.php" class="btn">Book a Service</a>
            <a href="logout.php" class="btn">Sign Out</a>
        </p>
    </div>
</body>
</html>