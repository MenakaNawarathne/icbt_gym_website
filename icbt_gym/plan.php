<?php
$page_title = "Plans - ICBT Kandy Fitness Center";
include "header.php";

// Include config file
require_once "config.php";

// Fetch membership plans
$sql = "SELECT * FROM membership_plans";
if($result = $conn->query($sql)){
    $membership_plans = $result->fetch_all(MYSQLI_ASSOC);
} else{
    echo "ERROR: Could not able to execute $sql. " . $conn->error;
}
?>
    <section id="membership" class="membership-section">
        <div class="membership-content">
            <h2>Membership Packages</h2>
            <p>
                Choose a plan that fits your fitness goals and schedule. Student-friendly pricing available!
            </p>
            <div class="membership-plans">
                <?php foreach($membership_plans as $plan): ?>
                <div class="plan-card">
                    <h3><?php echo htmlspecialchars($plan['name']); ?></h3>
                    <p style="font-size: 1.8em; font-weight: bold;">Rs. <?php echo number_format($plan['price'], 2); ?> / Month</p>
                    <p><?php echo htmlspecialchars($plan['description']); ?></p>
                    <ul>
                        <li>✔ <?php echo $plan['duration_days']; ?> Days Access</li>
                        <li>✔ <?php echo $plan['access_days_per_week']; ?> Days/Week</li>
                    </ul>
                    <button onclick="location.href='register.php'">
                        Join Now
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php include "footer.php"; ?>