<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Link to external CSS -->
</head>
</html>