<?php
session_start();
include 'dbconn.inc.php';

$successMessage = "";
$errorMessage = "";

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $sql = "DELETE FROM jobs WHERE job_id = $job_id";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Job deleted successfully!";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Job</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
    <script>
        function hideMessage() {
            var message = document.getElementById('message');
            if (message) {
                setTimeout(function() {
                    message.style.display = 'none';
                    window.location.href = 'manage_jobs.php'; // Redirect after message disappears
                }, 3000); // Hide after 3 seconds
            }
        }
    </script>
</head>
<body onload="hideMessage()">
    <h2>Delete Job</h2>

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

</body>
</html>



