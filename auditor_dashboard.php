<?php
session_start();
if ($_SESSION['role'] != 'Auditor') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Auditor Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        h2 {
            color: #333;
        }

        .btn {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
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
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #e53935;
        }

        /* Centered Welcome Message */
        .welcome-message {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Auditor Dashboard</h2>
        
        <!-- Welcome Message -->
        <div class="welcome-message">
            Welcome, Auditor! Choose an action below:
        </div>

        <!-- Action Buttons -->
        <a href="generate_report.php" class="btn">Generate Summary Report</a><br>
        <a href="view_logs.php" class="btn">View Factory Logs</a><br>

        <!-- Logout Button -->
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>

