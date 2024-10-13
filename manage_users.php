<?php
session_start();
include 'dbconn.inc.php';

// Check if user is an Administrator
if ($_SESSION['role'] != 'Administrator') {
    header("Location: login.php");
    exit();
}

// Add a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Use password hashing for security
    $role = $_POST['role'];

    // Insert new user into the database
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style>
        /* CSS for the Home and Logout buttons */
        .button-container {
            position: inline-block;
            bottom: 10px;
            left: 10px;
        }

        .home-button, .logout-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            margin-right: 0px;
            transition: background-color 0.3s ease;
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

</head>
<body>
    <h2>Manage Users</h2>

    <h3>Add a New User</h3>
    <form action="manage_users.php" method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        Role: 
        <select name="role">
            <option value="Administrator">Administrator</option>
            <option value="Factory Manager">Factory Manager</option>
            <option value="Production Operator">Production Operator</option>
            <option value="Auditor">Auditor</option>
        </select><br>
        <input type="submit" name="add_user" value="Add User">
    </form>


    <h3>Existing Users</h3>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>
                <!-- Redirect to edit_user.php with the user_id in the query string -->
                <a href="edit_user.php?user_id=<?php echo $row['user_id']; ?>">Edit</a> |
                <!-- Redirect to delete_user.php with the user_id -->
                <a href="delete_user.php?user_id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Home and Logout buttons at the bottom left of the page -->
    <div class="button-container">
        <a href="admin_dashboard.php" class="home-button">Home</a>
        <a href="logout.php" class="logout-button">Log Out</a>
    </div>

</body>
</html>





