<?php
session_start();
include 'dbconn.inc.php';

// Check if user is an Administrator
if ($_SESSION['role'] != 'Administrator') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prevent the administrator from deleting their own account
    if ($_SESSION['user_id'] == $user_id) {
        echo "You cannot delete your own account.";
    } else {
        $sql = "DELETE FROM users WHERE user_id = $user_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: manage_users.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete User</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
</head>
</html>