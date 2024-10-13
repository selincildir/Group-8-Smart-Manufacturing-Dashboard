<?php
// alerts.php
include 'dbconn.inc.php';

// Fetch machines that are offline
$offline_query = "SELECT * FROM machines WHERE status = 'offline'";
$offline_result = $conn->query($offline_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Offline Machine Alerts</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h2>Offline Machine Alerts</h2>

    <?php if ($offline_result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Machine Name</th>
                <th>Last Status Update</th>
                <th>Actions</th>
            </tr>
            <?php while($machine = $offline_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $machine['machine_name']; ?></td>
                <td><?php echo $machine['last_status_update']; ?></td>
                <td><a href="machine_performance.php?machine_id=<?php echo $machine['machine_id']; ?>">View Performance</a></td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>All machines are online.</p>
    <?php } ?>
</body>
</html>
