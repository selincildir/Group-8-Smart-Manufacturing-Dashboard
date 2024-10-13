<?php
session_start();
include 'dbconn.inc.php';

// Check if the user is a production operator
if ($_SESSION['role'] != 'Production Operator') {
    header("Location: login.php");
    exit();
}

// Handle task note creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $machine_id = $_POST['machine_id'];
    $note = $_POST['note'];
    $sql = "INSERT INTO task_notes (machine_id, operator, note) VALUES ('$machine_id', '".$_SESSION['username']."', '$note')";
    if ($conn->query($sql) === TRUE) {
        echo "Task note created successfully!";
    } else {
        echo "Error creating task note: " . $conn->error;
    }
}

// Fetch machines assigned to the operator
$sql = "SELECT * FROM machines WHERE assigned_operator = '".$_SESSION['username']."'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Task Note</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h2>Create Task Note</h2>
    <form method="POST" action="create_note.php">
        <label for="machine_id">Select Machine:</label>
        <select id="machine_id" name="machine_id" class="form-input">
            <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?php echo $row['machine_id']; ?>"><?php echo $row['machine_name']; ?></option>
            <?php } ?>
        </select><br>

        <label for="note">Task Note:</label>
        <textarea id="note" name="note" class="form-input" required></textarea><br>

        <input type="submit" value="Create Note" class="form-submit">
    </form>
</body>
</html>
