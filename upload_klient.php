<?php
session_start();
if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'klient') {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $folder_upload = 'uploads/klient/';
    $emri_file = basename($_FILES['file']['name']);
    $target_path = $folder_upload . $emri_file;

    if (!file_exists($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        echo "<p style='color:green;'>Dokumenti u ngarkua me sukses !</p>";
    } else {
        echo "<p style='color:red;'>Ngarkimi i dokumetit deshtoi!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ngarko dokument - Klient</title>
    <style>
       body {
            font-family: Arial;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
        }

        form {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input[type="file"] {
            margin: 10px 0;
            margin-left:10%;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left:14%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h2 {
            color: #333;
        }

    </style>
</head>
<body>
    <h2>Ngarkoni nje dokument</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required><br><br>
        <input type="submit" value="Ngarko dokumentin">
    </form>
</body>
</html>
