<?php
session_start();
include 'dbconn.inc.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Notification message placeholder
$notificationMessage = "";

// Update job status and add task notes logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $job_status = $_POST['job_status'];
    $task_note = $_POST['task_note'];

    // Update the jobs table
    $sql1 = "UPDATE jobs SET job_status = '$job_status' WHERE job_id = $job_id";
    if ($conn->query($sql1) === TRUE) {
        $notificationMessage = "Job status updated successfully!";
    } else {
        echo "Error updating job status in jobs table: " . $conn->error;
    }

    // Insert task notes into the task_notes table
    if (!empty($task_note)) {
        // Ensure task_notes table has the job_id and operator_id column
        $sql2 = "INSERT INTO task_notes (job_id, operator_id, note) VALUES ($job_id, ".$_SESSION['operator_id'].", '$task_note')";
        if ($conn->query($sql2) === TRUE) {
            $notificationMessage .= " Task note added successfully!";
        } else {
            echo "Error inserting task note: " . $conn->error;
        }
    }

    // Update the machine status based on job status
    $machine_status = '';
    if ($job_status == 'pending') {
        $machine_status = 'idle';
    } elseif ($job_status == 'in_progress') {
        $machine_status = 'active';
    } elseif ($job_status == 'completed') {
        $machine_status = 'maintenance';
    }

    if (!empty($machine_status)) {
        $sql3 = "UPDATE machines m 
                 JOIN jobs j ON m.machine_id = j.assigned_machine_id 
                 SET m.operational_status = '$machine_status' 
                 WHERE j.job_id = $job_id";

        if ($conn->query($sql3) === TRUE) {
            $notificationMessage .= " Machine operational status updated successfully!";
        } else {
            echo "Error updating machine status: " . $conn->error;
        }
    }
}

// Fetch assigned jobs from the jobs table using the logged-in operator's ID
$sql = "SELECT j.job_id, j.job_name, m.machine_name, j.description AS job_description, j.job_status AS status
        FROM jobs j 
        JOIN machines m ON j.assigned_machine_id = m.machine_id
        WHERE j.assigned_operator_id = '".$_SESSION['operator_id']."'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Assigned Jobs</title>
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
            position: inline-block;
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
            position: inline-block;
            bottom: 10px;
            left: 50px;
            z-index: 9999;
        }
    </style>
    <script>
        // Function to show and then hide the notification
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

            // Hide the notification after 3 seconds
            setTimeout(function() {
                notification.style.display = 'none';
                window.location.href = 'view_assigned_jobs.php'; // Redirect after message disappears
            }, 5000);
        }

        // Show the notification only after an update
        window.onload = function() {
            <?php if (!empty($notificationMessage)) { ?>
                showNotification("<?php echo $notificationMessage; ?>");
            <?php } ?>
        };

        function submitForm(jobId) {
            document.getElementById('statusForm-' + jobId).submit();
        }
    </script>
</head>
<body>

    <!-- Home button based on user type -->
    <a href="<?php echo $dashboard_link; ?>" class="home-button">Home</a>

    <h2>View Assigned Jobs</h2>
    
    <table>
        <thead>
            <tr>
                <th>Job Name</th>
                <th>Machine Name</th>
                <th>Job Description</th>
                <th>Status</th>
                <th>Task Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['job_name']; ?></td>
                <td><?php echo $row['machine_name']; ?></td>
                <td><?php echo $row['job_description']; ?></td>
                <td>
                    <form id="statusForm-<?php echo $row['job_id']; ?>" method="POST" action="view_assigned_jobs.php">
                        <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">
                        <select name="job_status" class="form-input">
                            <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="in_progress" <?php if ($row['status'] == 'in_progress') echo 'selected'; ?>>In Progress</option>
                            <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                        </select>
                        <textarea name="task_note" class="form-input" placeholder="Add task note here..."></textarea>
                        <input type="submit" value="Update Status" class="form-submit">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Log out button at the bottom left of the page -->
    <a href="logout.php" class="logout-button">Log Out</a>
    
</body>
</html>











