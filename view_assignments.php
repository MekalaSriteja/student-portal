<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("
    SELECT a.title, a.file_path, a.upload_date, u.username 
    FROM assignments a
    LEFT JOIN users u ON a.uploaded_by = u.id
    ORDER BY a.upload_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Assignments</title>
    <style>
        body {
            font-family: Arial;
            background: #f8f9fa;
            padding: 30px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px gray;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        .back {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>📋 Uploaded Assignments</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Uploaded By</th>
            <th>Date</th>
            <th>Download</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['upload_date']}</td>
                        <td><a href='{$row['file_path']}' download>📥 Download</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>No assignments uploaded yet.</td></tr>";
        }
        ?>
    </table>
    <div class='back'>
        <a href='dashboard.php'>⬅ Back to Dashboard</a>
    </div>
</body>
</html>
