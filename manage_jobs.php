<?php
session_start();
include 'dbconn.inc.php';

$successMessage = "";
$errorMessage = "";

// Add a new job
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_job'])) {
    $job_name = $_POST['job_name'];
    $description = $_POST['description'];
    $assigned_machine_id = $_POST['assigned_machine_id'];
    $assigned_operator_id = $_POST['assigned_operator_id'];
    $job_status = $_POST['job_status'];

    // Validation to check that IDs are positive integers
    if ($assigned_machine_id > 0 && $assigned_operator_id > 0) {
        $sql = "INSERT INTO jobs (job_name, description, assigned_machine_id, assigned_operator_id, job_status)
                VALUES ('$job_name', '$description', '$assigned_machine_id', '$assigned_operator_id', '$job_status')";

        if ($conn->query($sql) === TRUE) {
            // Update machine operational status based on job status
            $sql2 = "UPDATE machines SET operational_status = '$job_status' WHERE machine_id = $assigned_machine_id";
            $conn->query($sql2);

            // Update role_assignments with job status if relevant
            $sql3 = "UPDATE role_assignments SET job_status = '$job_status' WHERE operator_id = $assigned_operator_id";
            $conn->query($sql3);

            $successMessage = "New job added successfully!";
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    } else {
        $errorMessage = "Assigned Machine ID and Operator ID must be greater than 0.";
    }
}

// Fetch all jobs from the database
$sql = "SELECT * FROM jobs";
$result = $conn->query($sql);

// Fetch machines for dropdown
$machines_sql = "SELECT DISTINCT machine_id FROM machines";
$machines_result = $conn->query($machines_sql);

// Fetch operators for dropdown
$operators_sql = "SELECT DISTINCT operator_id FROM role_assignments";
$operators_result = $conn->query($operators_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Jobs</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
    <style>
        /* Style for Home and Logout buttons */
        .home-button {
            position: inline-block;
            top: 10px;
            left: 50px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            z-index: 1000; 
            transition: background-color 0.3s ease;
        }

        .logout-button {
            position: inline-block;
            bottom: 10px;
            left: 50px;
            padding: 10px 20px;
            background-color: #f44336; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            z-index: 1000; 
            transition: background-color 0.3s ease;
        }

        /* Hover effect for Home and Logout buttons */
        .home-button:hover {
            background-color: #45a049;
        }

        .logout-button:hover {
            background-color: #e53935;
        }

        /* Success/Error message styles */
        #message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }
    </style>

    <script>
        function hideMessage() {
            var message = document.getElementById('message');
            if (message) {
                setTimeout(function() {
                    message.style.display = 'none';
                }, 3000); 
            }
        }
    </script>
</head>
<body onload="hideMessage()">
    <!-- Home button to go back to dashboard -->
    <a href="manager_dashboard.php" class="home-button">Home</a>

    <h2>Manage Jobs</h2>

    <!-- Success/Error Messages -->
    <?php if ($successMessage != ""): ?>
        <div id="message" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
            <?php echo $successMessage; ?>
        </div>
    <?php elseif ($errorMessage != ""): ?>
        <div id="message" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <h3>Add a New Job</h3>
    <form action="manage_jobs.php" method="POST">
        Job Name: <input type="text" name="job_name" class="form-input" required><br>
        Description: <textarea name="description" class="form-input"></textarea><br>

        <!-- Machine ID Dropdown -->
        Assigned Machine ID: 
        <select name="assigned_machine_id" class="form-input" required>
            <option value="">Select Machine</option>
            <?php while ($machine = $machines_result->fetch_assoc()) { ?>
                <option value="<?php echo $machine['machine_id']; ?>"><?php echo $machine['machine_id']; ?></option>
            <?php } ?>
        </select><br>

        <!-- Operator ID Dropdown -->
        Assigned Operator ID: 
        <select name="assigned_operator_id" class="form-input" required>
            <option value="">Select Operator</option>
            <?php while ($operator = $operators_result->fetch_assoc()) { ?>
                <option value="<?php echo $operator['operator_id']; ?>"><?php echo $operator['operator_id']; ?></option>
            <?php } ?>
        </select><br>

        Job Status: 
        <select name="job_status" class="form-input">
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select><br>

        <input type="submit" name="add_job" value="Add Job" class="form-submit">
    </form>

    <h3>Existing Jobs</h3>
    <table border="1">
        <tr>
            <th>Job Name</th>
            <th>Description</th>
            <th>Assigned Machine ID</th>
            <th>Assigned Operator ID</th>
            <th>Status</th>
            <th>Operator's Note</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { 
            // Fetch the latest task note for the job
            $task_notes_sql = "SELECT note FROM task_notes WHERE job_id = " . $row['job_id'] . " ORDER BY created_at DESC LIMIT 1";
            $task_notes_result = $conn->query($task_notes_sql);
            $latest_task_note = $task_notes_result->fetch_assoc()['note'] ?? "No notes";
        ?>
        <tr>
            <td><?php echo $row['job_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['assigned_machine_id']; ?></td>
            <td><?php echo $row['assigned_operator_id']; ?></td>
            <td><?php echo $row['job_status']; ?></td>
            <td><?php echo $latest_task_note; ?></td>
            <td>
                <a href="edit_job.php?job_id=<?php echo $row['job_id']; ?>">Edit</a> |
                <a href="delete_job.php?job_id=<?php echo $row['job_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Fixed Logout button at the bottom-left -->
    <a href="logout.php" class="logout-button">Logout</a>
</body>
</html>








