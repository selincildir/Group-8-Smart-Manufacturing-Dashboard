<?php
session_start();
include 'dbconn.inc.php';

// Check if the user is a production operator
if ($_SESSION['role'] != 'Production Operator') {
    header("Location: login.php");
    exit();
}

// Determine the home button link based on the user role
$dashboard_link = '#'; // Default link if role is not set or not recognized
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Administrator') {
        $dashboard_link = 'admin_dashboard.php';
    } elseif ($_SESSION['role'] == 'Factory Manager') {
        $dashboard_link = 'manager_dashboard.php';
    } elseif ($_SESSION['role'] == 'Production Operator') {
        $dashboard_link = 'operator_dashboard.php';
    }
}

// Variable to hold the success message
$successMessage = "";

// Update machine status logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $machine_id = $_POST['machine_id'];
    $operational_status = $_POST['operational_status'];

    // Update the machines table
    $sql1 = "UPDATE machines SET operational_status = '$operational_status' WHERE machine_id = $machine_id";
    if ($conn->query($sql1) === TRUE) {
        $successMessage = "Machine status updated successfully!";
    } else {
        echo "Error updating machine status: " . $conn->error;
    }

    // Update the jobs table
    $sql2 = "UPDATE jobs SET status = '$operational_status' WHERE assigned_machine_id = $machine_id";
    if ($conn->query($sql2) === TRUE) {
        // No additional output for jobs update success
    } else {
        echo "Error updating job status in jobs table: " . $conn->error;
    }
}

// Check if the operator ID exists in the session
if (!isset($_SESSION['operator_id'])) {
    echo "Error: Operator ID is not set in the session.";
    exit();
}

// Fetch all machines
$sql = "SELECT DISTINCT machine_id, machine_name FROM machines";
$result = $conn->query($sql);

// Check if any machines are returned
if ($result->num_rows > 0) {
    // Machines found
} else {
    echo "No machines found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Machine Status</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        /* Style for Home and Logout buttons */
        .home-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            position: fixed;
            top: 10px;
            left: 50px;
            z-index: 9999;
        }

        .logout-button {
            display: inline-block;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            position: fixed;
            bottom: 200px;
            left: 50px;
            z-index: 9999;
        }
    </style>
    <script>
        // Function to hide the success message after 3 seconds
        function hideMessage() {
            var message = document.getElementById('successMessage');
            if (message) {
                setTimeout(function() {
                    message.style.display = 'none';
                }, 3000); 
            }
        }
    </script>
</head>
<body onload="hideMessage()">

    <!-- Home button based on user type -->
    <a href="<?php echo $dashboard_link; ?>" class="home-button">Home</a>

    <h2>Update Machine Status</h2>

    <!-- Display the success message if available -->
    <?php if ($successMessage != ""): ?>
        <div id="successMessage" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="update_machine_status.php">
        <label for="machine_id">Select Machine:</label>
        <select id="machine_id" name="machine_id" class="form-input" required>
            <option value="">Select a Machine</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['machine_id']; ?>"><?php echo $row['machine_name']; ?></option>
            <?php } ?>
        </select><br>

        <label for="operational_status">Update Status:</label>
        <select id="operational_status" name="operational_status" class="form-input" required>
            <option value="">-- Select Status --</option>
            <option value="active">Active</option>
            <option value="maintenance">Maintenance</option>
            <option value="idle">Idle</option>
        </select><br>

        <input type="submit" value="Update Status" class="form-submit">
    </form>

    <!-- Logout button at the bottom left of the page -->
    <a href="logout.php" class="logout-button">Log Out</a>

</body>
</html>






