<?php
session_start();
include 'dbconn.inc.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$successMessage = ""; // To store success message

if (isset($_GET['machine_id'])) {
    $machine_id = $_GET['machine_id'];

    // First, delete related rows from the role_assignments table
    $stmt1 = $conn->prepare("DELETE FROM role_assignments WHERE machine_id = ?");
    $stmt1->bind_param("i", $machine_id);
    $stmt1->execute();
    $stmt1->close();

    // Now, delete the machine from the machines table
    $stmt2 = $conn->prepare("DELETE FROM machines WHERE machine_id = ?");
    $stmt2->bind_param("i", $machine_id);

    if ($stmt2->execute() === TRUE) {
        $successMessage = "Machine and related assignments deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt2->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Machine</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>
        // Show notification and redirect
        function showNotificationAndRedirect() {
            var message = document.getElementById('successMessage');
            if (message) {
                setTimeout(function() {
                    message.style.display = 'none';
                    window.location.href = 'manage_machines.php'; // Redirect after notification disappears
                }, 3000); // Show message for 3 seconds
            }
        }
    </script>
</head>
<body onload="showNotificationAndRedirect()">
    <!-- Display the success message if available -->
    <?php if ($successMessage != ""): ?>
        <div id="successMessage" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>
</body>
</html>



  
