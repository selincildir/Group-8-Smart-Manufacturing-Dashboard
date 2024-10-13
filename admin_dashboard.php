<?php
session_start();
if ($_SESSION['role'] != 'Administrator') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Administrator Dashboard</title>
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

        /* Dashboard container styling */
        .dashboard-container {
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

        /* Button styling */
        .dashboard-link {
            display: block;
            margin: 10px 0;
            padding: 15px;
            font-size: 18px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            background-color: #4CAF50;
            transition: background-color 0.3s ease;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-link:hover {
            background-color: #45a049;
        }

        .dashboard-link i {
            margin-right: 8px;
        }

        /* Logout button styling */
        .logout-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #e53935;
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

    <div class="dashboard-container">
        <h2>Administrator Dashboard</h2>

        <!-- Dashboard Links -->
        <a href="manage_users.php" class="dashboard-link">
            <i class="fas fa-users"></i> Manage Users
        </a>
        <a href="view_logs.php" class="dashboard-link">
            <i class="fas fa-clipboard-list"></i> View Factory Logs
        </a>

        <!-- Logout Button -->
        <a href="logout.php" class="logout-button">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

        <!-- Footer -->
        <footer>
            © 2024 Admin Portal
        </footer>
    </div>

</body>
</html>

