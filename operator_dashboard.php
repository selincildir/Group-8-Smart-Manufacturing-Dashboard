<?php
session_start();
if ($_SESSION['role'] != 'Production Operator') {
    header("Location: login.php");
    exit();
}

// manage_machines.php
session_start();
if ($_SESSION['role'] != 'Factory Manager' && $_SESSION['role'] != 'Administrator' && $_SESSION['role'] != 'Production Operator') {
    header("Location: login.php");
    exit();
}


$malfunctioningMachines = true; // Set to true if there are any malfunctioning machines.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Production Operator Dashboard</title>

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

        h3 {
            margin-top: 30px;
            font-size: 1.5em;
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

        /* Alert styling */
        .alert {
            color: red;
            font-weight: bold;
            text-decoration: none;
            padding: 10px;
            display: inline-block;
            margin-top: 20px;
            cursor: pointer;
            border: 1px solid red;
            border-radius: 5px;
        }

        .blink {
            animation: blink-animation 1s steps(5, start) infinite;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }

        /* Centered Logout button */
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
    </style>

    <script>
        function blinkAlert() {
            var malfunctioning = <?php echo json_encode($malfunctioningMachines); ?>;
            if (malfunctioning) {
                var alertElement = document.getElementById('machineAlert');
                alertElement.classList.add('blink');
            }
        }

        window.onload = function() {
            blinkAlert();
        };
    </script>
</head>
<body>
    <!-- Centered Content -->
    <div class="container">
        <h2>Production Operator Dashboard</h2>
        
        <h3>Job Management</h3>
        <a href="view_assigned_jobs.php" class="btn">View Assigned Jobs</a><br>
        <a href="update_machine_status.php" class="btn">Update Machine Status</a><br>
        <a href="view_logs.php" class="btn">View Factory Logs</a>

        <h3>Machine Alerts</h3>
        <a href="manage_machines.php" id="machineAlert" class="alert">View Offline Machine Alerts</a>

        <!-- Centered Logout button -->
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>



