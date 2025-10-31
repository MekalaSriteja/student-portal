<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f0f0f0;
            padding: 30px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            margin: auto;
            text-align: center;
            box-shadow: 0 0 10px gray;
        }
        a {
            text-decoration: none;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?> 🎓</h2>
        <p>You have successfully logged in!</p>
        <p><a href="upload_assignment.php">📤 Upload Assignment</a></p>
<p><a href="view_assignments.php">📋 View Uploaded Assignments</a></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
