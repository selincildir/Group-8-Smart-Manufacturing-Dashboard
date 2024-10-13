<?php
session_start();
include 'dbconn.inc.php';

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Function to check and redirect user based on role
function checkUserRole($role)
{
    if ($_SESSION['role'] != $role && $_SESSION['role'] != 'Administrator' && $_SESSION['role'] != 'Production Operator') {
        header("Location: login.php");
        exit();
    }
}

// Call function to check role
checkUserRole('Factory Manager');

// Determine home button link based on role
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

// Add a new machine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_machine'])) {
    $machine_name = $_POST['machine_name'];
    $description = $_POST['description'];
    $operational_status = $_POST['operational_status'];
    $temperature = $_POST['temperature'];
    $pressure = $_POST['pressure'];
    $vibration = $_POST['vibration'];
    $humidity = $_POST['humidity'];
    $power_consumption = $_POST['power_consumption'];
    $maintenance_log = $_POST['maintenance_log'];
    $error_code = !empty($_POST['error_code']) ? $_POST['error_code'] : NULL;
    $last_maintenance = $_POST['last_maintenance'];

    $stmt = $conn->prepare("INSERT INTO machines (machine_name, description, operational_status, temperature, pressure, vibration, humidity, power_consumption, maintenance_log, error_code, last_maintenance) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        'ssssddddsss',
        $machine_name,
        $description,
        $operational_status,
        $temperature,
        $pressure,
        $vibration,
        $humidity,
        $power_consumption,
        $maintenance_log,
        $error_code,
        $last_maintenance
    );

    if ($stmt->execute()) {
        $successMessage = "New machine added successfully!";
        $log_sql = "INSERT INTO factory_logs (machine_name, timestamp) VALUES ('$machine_name', NOW())";
        $conn->query($log_sql);
    } else {
        echo "Error: " . $conn->error;
    }
} 

// Handle filtering functionality
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : 'all';
$where_clause = ($filter_status != 'all') ? "WHERE operational_status = '$filter_status'" : '';

// Fetch all machines or filtered machines
$sql = "SELECT * FROM machines $where_clause";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Machines</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .home-button, .logout-button {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }
        .home-button {
            background-color: #4CAF50; 
            margin-right: 10px;
        }
        .logout-button {
            background-color: #f44336; 
        }
        .home-button:hover {
            background-color: #45a049;
        }
        .logout-button:hover {
            background-color: #e53935;
        }
    </style>
    <script>
        function showNotification(message) {
            var notification = document.createElement('div');
            notification.id = 'notification';
            notification.innerHTML = message;
            notification.style.backgroundColor = '#d4edda';
            notification.style.color = '#155724';
            notification.style.padding = '10px';
            notification.style.border = '1px solid #c3e6cb';
            notification.style.marginBottom = '15px';
            notification.style.textAlign = 'center';
            notification.style.position = 'fixed';
            notification.style.top = '10px';
            notification.style.left = '50%';
            notification.style.transform = 'translateX(-50%)';
            notification.style.zIndex = '9999';
            document.body.appendChild(notification);

            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000);
        }

        window.onload = function() {
            <?php if (!empty($successMessage)) { ?>
                showNotification("<?php echo $successMessage; ?>");
            <?php } ?>
        };
    </script>
</head>
<body>
    <!-- Home button -->
    <a href="<?php echo $dashboard_link; ?>" class="home-button">Home</a>

    <h2>Manage Machines</h2>

    <h3>Add a New Machine</h3>
    <form name="machineForm" action="manage_machines.php" method="POST">
        <label for="machine_name">Machine Name:</label>
        <input type="text" id="machine_name" name="machine_name" class="form-input" required><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-input" required></textarea><br>
        
        <label for="operational_status">Status:</label>
        <select id="operational_status" name="operational_status" class="form-input" required>
            <option value="active">Active</option>
            <option value="maintenance">Maintenance</option>
            <option value="idle">Idle</option>
        </select><br>
        
        <label for="temperature">Temperature:</label>
        <input type="float" id="temperature" name="temperature" class="form-input" required><br>
        
        <label for="pressure">Pressure:</label>
        <input type="float" id="pressure" name="pressure" class="form-input" required><br>
        
        <label for="vibration">Vibration:</label>
        <input type="float" id="vibration" name="vibration" class="form-input" required><br>
        
        <label for="humidity">Humidity:</label>
        <input type="float" id="humidity" name="humidity" class="form-input" required><br>
        
        <label for="power_consumption">Power Consumption:</label>
        <input type="float" id="power_consumption" name="power_consumption" class="form-input" required><br>
        
        <label for="error_code">Error Code (Optional):</label>
        <select id="error_code" name="error_code" class="form-input">
            <option value=""></option>
            <option value="E101">E101</option>
            <option value="E202">E202</option>
            <option value="E303">E303</option>
            <option value="E404">E404</option>
            <option value="E505">E505</option>
        </select><br>
        
        <label for="maintenance_log">Maintenance Log:</label>
        <select id="maintenance_log" name="maintenance_log" class="form-input">
            <option value=""></option>
            <option value="Part Replacement">Part Replacement</option>
            <option value="Software Update">Software Update</option>
            <option value="Catastrophic failure">Catastrophic failure</option>
            <option value="Routine Check">Routine Check</option>
            <option value="">No Action Required</option>
        </select><br>
        
        <label for="last_maintenance">Last Maintenance Date:</label>
        <input type="date" id="last_maintenance" name="last_maintenance" class="form-input" required><br>
        <input type="submit" name="add_machine" value="Add Machine" class="form-submit">
    </form>

    <h3>Existing Machines</h3>

    <!-- Filter Dropdown -->
    <form method="GET" action="">
        <label for="filter_status">Filter by Status:</label>
        <select name="filter_status" id="filter_status" onchange="this.form.submit()">
            <option value="all" <?php if ($filter_status == 'all') echo 'selected'; ?>>All</option>
            <option value="active
            <option value="active" <?php if ($filter_status == 'active') echo 'selected'; ?>>Active</option>
<option value="maintenance" <?php if ($filter_status == 'maintenance') echo 'selected'; ?>>Maintenance</option>
<option value="idle" <?php if ($filter_status == 'idle') echo 'selected'; ?>>Idle</option>
        </select>
    </form>

    <table>
        <thead>
            <tr>
                <th>Machine Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Temperature</th>
                <th>Pressure</th>
                <th>Vibration</th>
                <th>Humidity</th>
                <th>Power Consumption</th>
                <th>Maintenance Log</th>
                <th>Error Code</th>
                <th>Last Maintenance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['machine_name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['operational_status']); ?></td>
                <td><?php echo htmlspecialchars($row['temperature']); ?></td>
                <td><?php echo htmlspecialchars($row['pressure']); ?></td>
                <td><?php echo htmlspecialchars($row['vibration']); ?></td>
                <td><?php echo htmlspecialchars($row['humidity']); ?></td>
                <td><?php echo htmlspecialchars($row['power_consumption']); ?></td>
                <td><?php echo htmlspecialchars($row['maintenance_log']); ?></td>
                <td><?php echo htmlspecialchars($row['error_code']); ?></td>
                <td><?php echo htmlspecialchars($row['last_maintenance']); ?></td>
                <td>
                    <a href="edit_machine.php?machine_id=<?php echo $row['machine_id']; ?>">Edit</a> |
                    <a href="delete_machine.php?machine_id=<?php echo $row['machine_id']; ?>" onclick="return confirm('Are you sure you want to delete this machine?');">Delete</a> |
                    <a href="machine_performance.php?machine_name=<?php echo urlencode($row['machine_name']); ?>">View Performance</a> |
                    <a href="view_logs.php?date=<?php echo date('Y-m-d'); ?>">Factory Logs</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- Logout button -->
    <a href="logout.php" class="logout-button">Logout</a>
</body>
</html>











