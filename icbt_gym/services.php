<?php
$page_title = "Services - ICBT Kandy Fitness Center";
include "header.php";

// Include config file
require_once "config.php";

// Fetch services
$sql = "SELECT * FROM services";
if($result = $conn->query($sql)){
    $services = $result->fetch_all(MYSQLI_ASSOC);
} else{
    echo "ERROR: Could not able to execute $sql. " . $conn->error;
}
?>
    <section id="services" class="services-section">
        <div class="services-content">
            <h2>Our Services</h2>
            <div class="service-card-container">
                <?php foreach($services as $service): ?>
                <div class="service-card">
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                    <p>Duration: <?php echo $service['duration_minutes']; ?> minutes</p>
                    <p>Price: Rs. <?php echo number_format($service['price'], 2); ?></p>
                    <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <button onclick="location.href='booking.php?service_id=<?php echo $service['id']; ?>'">Book Now</button>
                    <?php else: ?>
                    <button onclick="location.href='login.php'">Login to Book</button>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php include "footer.php"; ?>