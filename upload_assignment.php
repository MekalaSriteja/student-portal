<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["assignment"])) {
    $title = $_POST['title'];
    $uploaded_by = $_SESSION['username'];
    $file_name = $_FILES["assignment"]["name"];
    $temp_name = $_FILES["assignment"]["tmp_name"];
    $target_dir = "uploads/" . basename($file_name);

    if (move_uploaded_file($temp_name, $target_dir)) {
        // Insert into database
        $sql = "INSERT INTO assignments (title, file_path, uploaded_by)
                VALUES ('$title', '$target_dir', 
                (SELECT id FROM users WHERE username='$uploaded_by'))";

        if ($conn->query($sql) === TRUE) {
            $message = "✅ Assignment uploaded successfully!";
        } else {
            $message = "❌ Database error: " . $conn->error;
        }
    } else {
        $message = "❌ Failed to upload file!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Assignment</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
            width: 350px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        p {
            color: green;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h2>Upload Assignment</h2>
        <input type="text" name="title" placeholder="Enter Assignment Title" required>
        <input type="file" name="assignment" required>
        <button type="submit">Upload</button>
        <p><?php echo $message; ?></p>
        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </form>
</body>
</html>
