<?php
session_start();
include 'dbconn.inc.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if machine_name is passed correctly
if (!isset($_GET['machine_name'])) {
    echo "<p style='color: red;'>Error: No machine name provided. Please select a valid machine from the dashboard.</p>";
    echo "<a href='manage_machines.php'>Go back to dashboard</a>";
    exit();
} else {
    $machine_name = $_GET['machine_name'];
}

// Use prepared statements to fetch machine details
$stmt = $conn->prepare("SELECT * FROM machines WHERE machine_name = ?");
$stmt->bind_param("s", $machine_name);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "<p style='color: red;'>Error: No machine found with the provided name.</p>";
    echo "<a href='manage_machines.php'>Go back to dashboard</a>";
    exit();
}
$machine = $result->fetch_assoc();
$stmt->close();

// Generate a random performance percentage between 50% and 100%
$performance_percentage = rand(50, 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Machine Performance</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 30px;
            margin: 20px auto;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .performance-level {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
        }

        .dashboard-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dashboard-link:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Performance for <?php echo htmlspecialchars($machine['machine_name']); ?></h2>

        <p>The current performance level is:</p>
        <p class="performance-level"><?php echo $performance_percentage; ?>%</p>

        <!-- Link to go back to the dashboard -->
        <a href="manage_machines.php" class="dashboard-link">Go back to dashboard</a>
    </div>
</body>
</html>









