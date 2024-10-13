<?php
session_start();
include 'dbconn.inc.php';

// Check if user is an Administrator
if ($_SESSION['role'] != 'Administrator') {
    header("Location: login.php");
    exit();
}

// Fetch user details by ID
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

// Update user details (role)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $username = $_POST['username'];  
    $role = $_POST['role'];

    $sql = "UPDATE users SET username = '$username', role = '$role' WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_users.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>

    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
</head>
<body>
    <h2>Edit User</h2>
    <form action="edit_user.php?user_id=<?php echo $user_id; ?>" method="POST">
        Username: <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
        Role: 
        <select name="role">
            <option value="Administrator" <?php if ($user['role'] == 'Administrator') echo 'selected'; ?>>Administrator</option>
            <option value="Factory Manager" <?php if ($user['role'] == 'Factory Manager') echo 'selected'; ?>>Factory Manager</option>
            <option value="Production Operator" <?php if ($user['role'] == 'Production Operator') echo 'selected'; ?>>Production Operator</option>
            <option value="Auditor" <?php if ($user['role'] == 'Auditor') echo 'selected'; ?>>Auditor</option>
        </select><br>
        <input type="submit" name="update_user" value="Update User">
    </form>
    <!-- Go back to dashboard link -->
    <a href="manage_users.php" style="display: inline-block; margin-top: 10px; color: #4CAF50; text-decoration: none; font-size: 16px;">Go back to dashboard</a>
</body>
</html>
