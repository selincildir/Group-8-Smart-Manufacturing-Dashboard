<?php
session_start();
if ($_SESSION['role'] != 'Auditor') {
    header("Location: login.php");
    exit();
}
include 'dbconn.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get date range from form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch summary data from factory_logs for the specified date range
    $sql = "SELECT machine_name, COUNT(*) as total_logs, 
            AVG(temperature) as average_temperature, 
            AVG(pressure) as average_pressure, 
            AVG(vibration) as average_vibration, 
            AVG(humidity) as average_humidity, 
            AVG(power_consumption) as average_power_consumption
            FROM factory_logs 
            WHERE timestamp BETWEEN ? AND ?
            GROUP BY machine_name";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare data for displaying
    $reports = [];
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
    
    // Insert report into summary_reports table
    foreach ($reports as $report) {
        $insert_sql = "INSERT INTO summary_reports 
                      (machine_name, start_date, end_date, total_logs, average_temperature, average_pressure, average_vibration, average_humidity, average_power_consumption)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param(
            "sssdddddd", 
            $report['machine_name'], 
            $start_date, 
            $end_date, 
            $report['total_logs'], 
            $report['average_temperature'], 
            $report['average_pressure'], 
            $report['average_vibration'], 
            $report['average_humidity'], 
            $report['average_power_consumption']
        );
        $insert_stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Generate Summary Report</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px; 
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 85%; 
            max-width: 1200px; 
        }

        h2 {
            color: #333;
            font-size: 2em; 
        }

        .btn {
            display: inline-block;
            margin: 15px 0;
            padding: 10px 20px; 
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
            font-size: 1em; 
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Logout and Home button styling */
        .home-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

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
            font-size: 1em; 
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #e53935;
        }

        .home-button:hover {
            background-color: #45a049;
        }

        
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            table-layout: auto;
            font-size: 1em; 
        }

        table th, table td {
            padding: 10px; 
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #ddd;
        }

        table td {
            background-color: #fff;
            border: 1px solid #ddd;
            color: #333;
        }

        table tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Generate Summary Report</h2>

        <form action="generate_report.php" method="POST">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required><br><br>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required><br><br>

            <input type="submit" value="Generate Report" class="btn">
        </form>

        <?php if (isset($reports) && count($reports) > 0): ?>
            <h3>Report from <?php echo $start_date; ?> to <?php echo $end_date; ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Machine Name</th>
                        <th>Total Logs</th>
                        <th>Average Temperature</th>
                        <th>Average Pressure</th>
                        <th>Average Vibration</th>
                        <th>Average Humidity</th>
                        <th>Average Power Consumption</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?php echo $report['machine_name']; ?></td>
                            <td><?php echo $report['total_logs']; ?></td>
                            <td><?php echo round($report['average_temperature'], 2); ?></td>
                            <td><?php echo round($report['average_pressure'], 2); ?></td>
                            <td><?php echo round($report['average_vibration'], 2); ?></td>
                            <td><?php echo round($report['average_humidity'], 2); ?></td>
                            <td><?php echo round($report['average_power_consumption'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Home button and Logout button -->
        <a href="auditor_dashboard.php" class="home-button">Home</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>





