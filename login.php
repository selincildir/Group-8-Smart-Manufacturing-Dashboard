<?php
session_start();
include 'dbconn.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple query to validate username and password
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        // Set the operator_id in session if the user is a Production Operator
        if ($user['role'] == 'Production Operator') {
            $_SESSION['operator_id'] = $user['user_id']; 
        }

        // Redirect based on role
        if ($user['role'] == 'Administrator') {
            header("Location: admin_dashboard.php");
        } elseif ($user['role'] == 'Factory Manager') {
            header("Location: manager_dashboard.php");
        } elseif ($user['role'] == 'Production Operator') {
            header("Location: operator_dashboard.php");
        } elseif ($user['role'] == 'Auditor') {
            header("Location: auditor_dashboard.php");
        }
    } else {
        echo "<p class='error'>Invalid login credentials</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome Icons -->
    <style>
        /* General body styling */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #ece9e6, #ffffff);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login form container styling */
        .login-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 30px;
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
        }

        /* Input field styling */
        .input-field {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Button styling */
        .submit-button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .submit-button:hover {
            background-color: #45a049;
        }

        /* Error message styling */
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Footer styling */
        footer {
            margin-top: 30px;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" class="input-field" placeholder="Username" required>
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <input type="submit" value="Login" class="submit-button">
        </form>
    </div>
</body>
</html>



