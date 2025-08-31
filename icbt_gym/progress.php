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

$page_title = "Progress Tracking";
include "header.php";

// Fetch user's progress records
$sql = "SELECT * FROM progress WHERE user_id = ? ORDER BY date DESC";
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("i", $_SESSION["id"]);
    if($stmt->execute()){
        $result = $stmt->get_result();
        $progress_records = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

// Process form submission for new progress record
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $date = trim($_POST["date"]);
    $weight = !empty(trim($_POST["weight"])) ? trim($_POST["weight"]) : NULL;
    $height = !empty(trim($_POST["height"])) ? trim($_POST["height"]) : NULL;
    $body_fat_percentage = !empty(trim($_POST["body_fat_percentage"])) ? trim($_POST["body_fat_percentage"]) : NULL;
    $notes = trim($_POST["notes"]);
    
    $sql = "INSERT INTO progress (user_id, date, weight, height, body_fat_percentage, notes) VALUES (?, ?, ?, ?, ?, ?)";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("isddds", $_SESSION["id"], $date, $weight, $height, $body_fat_percentage, $notes);
        if($stmt->execute()){
            $success_msg = "Progress record added successfully!";
            // Refresh the page to show the new record
            header("location: progress.php");
            exit;
        } else{
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
?>
    <section class="progress-section">
        <div class="progress-content">
            <h2>Track Your Progress</h2>
            <?php if(!empty($success_msg)): ?>
            <div class="alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            <div class="progress-form-container">
                <h3>Add New Progress Record</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" step="0.1" name="weight">
                    </div>
                    <div class="form-group">
                        <label>Height (cm)</label>
                        <input type="number" step="0.1" name="height">
                    </div>
                    <div class="form-group">
                        <label>Body Fat Percentage (%)</label>
                        <input type="number" step="0.1" name="body_fat_percentage">
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">Add Record</button>
                    </div>
                </form>
            </div>
            <div class="progress-records">
                <h3>Your Progress History</h3>
                <?php if(!empty($progress_records)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Weight (kg)</th>
                            <th>Height (cm)</th>
                            <th>Body Fat (%)</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($progress_records as $record): ?>
                        <tr>
                            <td><?php echo $record['date']; ?></td>
                            <td><?php echo $record['weight'] ?? 'N/A'; ?></td>
                            <td><?php echo $record['height'] ?? 'N/A'; ?></td>
                            <td><?php echo $record['body_fat_percentage'] ?? 'N/A'; ?></td>
                            <td><?php echo $record['notes'] ?? ''; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>No progress records found. Start tracking your progress!</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php include "footer.php"; ?>