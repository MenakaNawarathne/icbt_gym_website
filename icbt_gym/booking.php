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

$page_title = "Book a Service";
include "header.php";

// Get service ID from URL
$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : '';

// Fetch service details
$sql = "SELECT * FROM services WHERE id = ?";
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("i", $service_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $service = $result->fetch_assoc();
        } else{
            echo "Service not found.";
            exit;
        }
    }
    $stmt->close();
}

// Fetch trainers for this service (if any)
$trainers = [];
$sql = "SELECT t.* FROM trainers t 
        JOIN trainer_services ts ON t.id = ts.trainer_id 
        WHERE ts.service_id = ?";
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("i", $service_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        $trainers = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

// Process booking form
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $booking_date = trim($_POST["booking_date"]);
    $booking_time = trim($_POST["booking_time"]);
    $trainer_id = !empty($_POST["trainer_id"]) ? trim($_POST["trainer_id"]) : NULL;
    $notes = trim($_POST["notes"]);
    
    // Insert booking
    $sql = "INSERT INTO bookings (user_id, service_id, trainer_id, booking_date, booking_time, notes) VALUES (?, ?, ?, ?, ?, ?)";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("iissss", $_SESSION["id"], $service_id, $trainer_id, $booking_date, $booking_time, $notes);
        if($stmt->execute()){
            $success_msg = "Your booking has been submitted successfully!";
        } else{
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
?>
    <section class="booking-section">
        <div class="booking-content">
            <h2>Book <?php echo htmlspecialchars($service['name']); ?></h2>
            <?php if(!empty($success_msg)): ?>
            <div class="alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?service_id=" . $service_id); ?>" method="POST">
                <div class="form-group">
                    <label>Service</label>
                    <input type="text" value="<?php echo htmlspecialchars($service['name']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" value="<?php echo $service['duration_minutes']; ?> minutes" readonly>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="text" value="Rs. <?php echo number_format($service['price'], 2); ?>" readonly>
                </div>
                <?php if(!empty($trainers)): ?>
                <div class="form-group">
                    <label>Select Trainer (Optional)</label>
                    <select name="trainer_id">
                        <option value="">No Preference</option>
                        <?php foreach($trainers as $trainer): ?>
                        <option value="<?php echo $trainer['id']; ?>"><?php echo htmlspecialchars($trainer['first_name'] . ' ' . $trainer['last_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Preferred Date</label>
                    <input type="date" name="booking_date" required>
                </div>
                <div class="form-group">
                    <label>Preferred Time</label>
                    <input type="time" name="booking_time" required>
                </div>
                <div class="form-group">
                    <label>Additional Notes</label>
                    <textarea name="notes" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Submit Booking</button>
                </div>
            </form>
        </div>
    </section>
<?php include "footer.php"; ?>