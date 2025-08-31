<?php
$page_title = "Contact - ICBT Kandy Fitness Center";
include "header.php";

// Include config file
require_once "config.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Get form data
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);
    
    // Prepare an insert statement
    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
     
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("ssss", $param_name, $param_email, $param_subject, $param_message);
        
        // Set parameters
        $param_name = $name;
        $param_email = $email;
        $param_subject = $subject;
        $param_message = $message;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $success_msg = "Thank you for contacting us! We'll get back to you soon.";
        } else{
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
?>
    <section id="contact" class="contact-section">
        <div class="contact-content">
            <h2>Contact Us</h2>
            <?php 
            if(!empty($success_msg)){
                echo '<div class="alert-success">' . $success_msg . '</div>';
            }        
            ?>
            <div class="contact-flex-container">
                <div class="contact-info-block">
                    <h3>📍 Visit Us</h3>
                    <p>ICBT Kandy Campus,<br>No. 398, Peradeniya Road,<br>Kandy, Sri Lanka</p>
                    <h3>📞 Call</h3>
                    <p>+94 81 223 4567</p>
                    <h3>📧 Email</h3>
                    <p>fitness@icbtkandy.edu.lk</p>
                    <h3>🕒 Opening Hours</h3>
                    <p>Mon – Sat: 6:00 AM – 8:00 PM<br>Sunday: Closed</p>
                </div>
                <div class="contact-info-block">
                    <form class="contact-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="text" name="name" placeholder="Your Name" required>
                        <input type="email" name="email" placeholder="Your Email" required>
                        <input type="text" name="subject" placeholder="Subject" required>
                        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                        <button type="submit" class="contact-form-button">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php include "footer.php"; ?>