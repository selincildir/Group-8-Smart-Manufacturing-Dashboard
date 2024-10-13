<?php
session_start();
include 'dbconn.inc.php';

$successMessage = "";
$errorMessage = "";

// Fetch job details
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $sql = "SELECT * FROM jobs WHERE job_id = $job_id";
    $result = $conn->query($sql);
    $job = $result->fetch_assoc();
}

// Fetch unique machines for dropdown
$machines_sql = "SELECT DISTINCT machine_id FROM machines WHERE machine_id > 0";
$machines_result = $conn->query($machines_sql);

// Fetch unique operators for dropdown
$operators_sql = "SELECT DISTINCT operator_id FROM role_assignments WHERE operator_id > 0";
$operators_result = $conn->query($operators_sql);

// Update job details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_job'])) {
    $job_name = $_POST['job_name'];
    $description = $_POST['description'];
    $assigned_machine_id = $_POST['assigned_machine_id'];
    $assigned_operator_id = $_POST['assigned_operator_id'];
    $job_status = $_POST['job_status'];

    // Validation to ensure IDs are greater than zero
    if ($assigned_machine_id > 0 && $assigned_operator_id > 0) {
        $sql = "UPDATE jobs SET 
                job_name = '$job_name', 
                description = '$description', 
                assigned_machine_id = '$assigned_machine_id', 
                assigned_operator_id = '$assigned_operator_id',
                job_status = '$job_status'
                WHERE job_id = $job_id";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Job updated successfully!";
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    } else {
        $errorMessage = "Assigned Machine ID and Operator ID must be greater than 0.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Job</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
    <script>
        function hideMessage() {
            var message = document.getElementById('message');
            if (message) {
                setTimeout(function() {
                    message.style.display = 'none';
                    window.location.href = 'manage_jobs.php'; // Redirect after message disappears
                }, 3000); // Hide message after 3 seconds and redirect
            }
        }
    </script>
</head>
<body onload="hideMessage()">
    <h2>Edit Job</h2>

    <!-- Success/Error Messages -->
    <?php if ($successMessage != ""): ?>
        <div id="message" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            <?php echo $successMessage; ?>
        </div>
    <?php elseif ($errorMessage != ""): ?>
        <div id="message" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <form action="edit_job.php?job_id=<?php echo $job_id; ?>" method="POST">
        Job Name: <input type="text" name="job_name" value="<?php echo $job['job_name']; ?>" class="form-input" required><br>
        Description: <textarea name="description" class="form-input"><?php echo $job['description']; ?></textarea><br>

        <!-- Machine ID Dropdown -->
        Assigned Machine ID: 
        <select name="assigned_machine_id" class="form-input" required>
            <option value="">Select Machine</option>
            <?php while ($machine = $machines_result->fetch_assoc()) { ?>
                <option value="<?php echo $machine['machine_id']; ?>" <?php if ($machine['machine_id'] == $job['assigned_machine_id']) echo 'selected'; ?>>
                    <?php echo $machine['machine_id']; ?>
                </option>
            <?php } ?>
        </select><br>

        <!-- Operator ID Dropdown -->
        Assigned Operator ID: 
        <select name="assigned_operator_id" class="form-input" required>
            <option value="">Select Operator</option>
            <?php while ($operator = $operators_result->fetch_assoc()) { ?>
                <option value="<?php echo $operator['operator_id']; ?>" <?php if ($operator['operator_id'] == $job['assigned_operator_id']) echo 'selected'; ?>>
                    <?php echo $operator['operator_id']; ?>
                </option>
            <?php } ?>
        </select><br>

        Job Status: 
        <select name="job_status" class="form-input">
            <option value="pending" <?php if ($job['job_status'] == 'pending') echo 'selected'; ?>>Pending</option>
            <option value="in_progress" <?php if ($job['job_status'] == 'in_progress') echo 'selected'; ?>>In Progress</option>
            <option value="completed" <?php if ($job['job_status'] == 'completed') echo 'selected'; ?>>Completed</option>
        </select><br>
        <input type="submit" name="update_job" value="Update Job" class="form-submit">
    </form>
    <!-- Go back to dashboard link -->
    <a href="manage_jobs.php" style="display: inline-block; margin-top: 10px; color: #4CAF50; text-decoration: none; font-size: 16px;">Go back to dashboard</a>
</body>
</html>





