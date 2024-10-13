<?php
session_start();
include 'dbconn.inc.php';

// Fetch machine details by ID
if (isset($_GET['machine_id'])) {
    $machine_id = $_GET['machine_id'];
    $sql = "SELECT * FROM machines WHERE machine_id = $machine_id";
    $result = $conn->query($sql);
    $machine = $result->fetch_assoc();
}

// Variable to hold the success message
$successMessage = "";

// Update machine details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_machine'])) {
    $machine_name = $_POST['machine_name'];
    $description = $_POST['description'];
    $operational_status = $_POST['operational_status'];
    $temperature = $_POST['temperature'];
    $pressure = $_POST['pressure'];
    $vibration = $_POST['vibration'];
    $humidity = $_POST['humidity'];
    $power_consumption = $_POST['power_consumption'];
    $maintenance_log = $_POST['maintenance_log'];
    $error_code = $_POST['error_code'];
    $last_maintenance = $_POST['last_maintenance'];

    $sql = "UPDATE machines SET 
            machine_name = '$machine_name', 
            description = '$description', 
            operational_status = '$operational_status', 
            temperature = '$temperature',
            pressure = '$pressure',
            vibration = '$vibration',
            humidity = '$humidity',
            power_consumption = '$power_consumption',
            maintenance_log = '$maintenance_log',
            error_code = '$error_code',
            last_maintenance = '$last_maintenance'
            WHERE machine_id = $machine_id";
    
    if ($conn->query($sql) === TRUE) {
        $successMessage = "Machine status updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Machine</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script>
        // Function to hide the success message and redirect after 3 seconds
        function showNotificationAndRedirect() {
            var message = document.getElementById('successMessage');
            if (message) {
                setTimeout(function() {
                    message.style.display = 'none';
                    window.location.href = 'manage_machines.php'; // Redirect after message disappears
                }, 3000); // Hide message after 3 seconds
            }
        }
    </script>
</head>
<body onload="showNotificationAndRedirect()">
    <h2>Edit Machine</h2>

    <!-- Display the success message if available -->
    <?php if ($successMessage != ""): ?>
        <div id="successMessage" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form action="edit_machine.php?machine_id=<?php echo $machine_id; ?>" method="POST" class="machine-form">
        <label for="machine_name">Machine Name:</label>
        <input type="text" id="machine_name" name="machine_name" class="form-input" value="<?php echo $machine['machine_name']; ?>" required><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-input"><?php echo $machine['description']; ?></textarea><br>
        
        <label for="operational_status">Status:</label>
        <select id="operational_status" name="operational_status" class="form-input">
            <option value="active" <?php if ($machine['operational_status'] == 'active') echo 'selected'; ?>>Active</option>
            <option value="maintenance" <?php if ($machine['operational_status'] == 'maintenance') echo 'selected'; ?>>Maintenance</option>
            <option value="idle" <?php if ($machine['operational_status'] == 'idle') echo 'selected'; ?>>Idle</option>
        </select><br>
        
        <label for="temperature">Temperature:</label>
        <input type="float" id="temperature" name="temperature" class="form-input" value="<?php echo $machine['temperature']; ?>" required><br>
        
        <label for="pressure">Pressure:</label>
        <input type="float" id="pressure" name="pressure" class="form-input" value="<?php echo $machine['pressure']; ?>" required><br>
        
        <label for="vibration">Vibration:</label>
        <input type="float" id="vibration" name="vibration" class="form-input" value="<?php echo $machine['vibration']; ?>" required><br>
        
        <label for="humidity">Humidity:</label>
        <input type="float" id="humidity" name="humidity" class="form-input" value="<?php echo $machine['humidity']; ?>" required><br>
        
        <label for="power_consumption">Power Consumption:</label>
        <input type="float" id="power_consumption" name="power_consumption" class="form-input" value="<?php echo $machine['power_consumption']; ?>" required><br>
        
        <label for="error_code">Error Code:</label>
        <select id="error_code" name="error_code" class="form-input">
            <option value="" <?php if ($machine['error_code'] == '') echo 'selected'; ?>></option>
            <option value="E101" <?php if ($machine['error_code'] == 'E101') echo 'selected'; ?>>E101</option>
            <option value="E202" <?php if ($machine['error_code'] == 'E202') echo 'selected'; ?>>E202</option>
            <option value="E303" <?php if ($machine['error_code'] == 'E303') echo 'selected'; ?>>E303</option>
            <option value="E404" <?php if ($machine['error_code'] == 'E404') echo 'selected'; ?>>E404</option>
            <option value="E505" <?php if ($machine['error_code'] == 'E505') echo 'selected'; ?>>E505</option>
        </select><br>

        <label for="maintenance_log">Maintenance Log:</label>
        <select id="maintenance_log" name="maintenance_log" class="form-input">
            <option value="" <?php if ($machine['maintenance_log'] == '') echo 'selected'; ?>></option>
            <option value="Part Replacement" <?php if ($machine['maintenance_log'] == 'Part Replacement') echo 'selected'; ?>>Part Replacement</option>
            <option value="Software Update" <?php if ($machine['maintenance_log'] == 'Software Update') echo 'selected'; ?>>Software Update</option>
            <option value="Catastrophic failure" <?php if ($machine['maintenance_log'] == 'Catastrophic failure') echo 'selected'; ?>>Catastrophic failure</option>
            <option value="Routine Check" <?php if ($machine['maintenance_log'] == 'Routine Check') echo 'selected'; ?>>Routine Check</option>
            <option value="">No Action Required</option>
        </select><br>
        
        <label for="last_maintenance">Last Maintenance Date:</label>
        <input type="date" id="last_maintenance" name="last_maintenance" class="form-input" value="<?php echo $machine['last_maintenance']; ?>" required><br>
        
        <input type="submit" name="update_machine" value="Update Machine" class="form-submit">
    </form>
    <!-- Go back to dashboard link -->
    <a href="manage_machines.php" style="display: inline-block; margin-top: 10px; color: #4CAF50; text-decoration: none; font-size: 16px;">Go back to dashboard</a>
</body>
</html>


