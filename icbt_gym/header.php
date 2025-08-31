<?php
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title : "ICBT Kandy Fitness Center"; ?></title>
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
        
          <?php 
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
              echo '<li><a href="dashboard.php">Dashboard</a></li>';
              echo '<li><a href="logout.php">Logout</a></li>';
          } else {
              echo '<li><a href="login.php">Login</a></li>';
          }
          ?>
        </ul>
      </nav>
    </div>
  </header>