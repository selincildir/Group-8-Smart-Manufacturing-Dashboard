<?php
session_start();
include 'dbconn.inc.php';

$sql = "SELECT * FROM factory_logs ORDER BY timestamp DESC";
$result = $conn->query($sql);

// Determine the home button link based on the user role
$dashboard_link = '#'; // Default link if role is not set or not recognized
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Administrator') {
        $dashboard_link = 'admin_dashboard.php';
    } elseif ($_SESSION['role'] == 'Production Operator') {
        $dashboard_link = 'operator_dashboard.php';
    } elseif ($_SESSION['role'] == 'Auditor') {
        $dashboard_link = 'auditor_dashboard.php';
    } elseif ($_SESSION['role'] == 'Factory Manager') {
        $dashboard_link = 'manager_dashboard.php';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Factory Logs</title>

    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->

    <style>
        /* CSS for the Home and Logout buttons */
        .home-button, .logout-button {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            position: inline-block;
            bottom: 10px;
            z-index: 9999;
        }

        .home-button {
            background-color: #4CAF50;
            color: white;
            left: 40px; 
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            left: 130px; 
        }
    </style>
</head>
<body>

    <h2>Factory Logs</h2>
    <table border="1">
        <tr>
            <th>Timestamp</th>
            <th>Machine Name</th>
            <th>Temperature</th>
            <th>Pressure</th>
            <th>Vibration</th>
            <th>Operational Status</th>
            <th>Error Code</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['timestamp']; ?></td>
                <td><?php echo $row['machine_name']; ?></td>
                <td><?php echo $row['temperature']; ?></td>
                <td><?php echo $row['pressure']; ?></td>
                <td><?php echo $row['vibration']; ?></td>
                <td><?php echo $row['operational_status']; ?></td>
                <td><?php echo $row['error_code']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <!-- Home and Log out buttons at the bottom left of the page -->
    <a href="<?php echo $dashboard_link; ?>" class="home-button">Home</a>
    <a href="logout.php" class="logout-button">Log Out</a>

</body>
</html>




