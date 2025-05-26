<?php
session_start();
include 'config.php';

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'instruktor') {
    header("Location: login.html");
    exit;
}

$id_instruktor = $_SESSION['id_perdoruesi'];

$sql = "SELECT * FROM Klasa WHERE id_instruktori = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_instruktor); 
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Klasat e instruktorit</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
            max-width: 500px;
            margin: 0 auto;
        }

        li {
            background-color: #ffffff;
            margin: 10px 0;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s;
        }

        li:hover {
            background-color: #f0f0ff;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Klasat tuaja</h2>
    <ul>
        <?php while ($klasa = $result->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($klasa['emer_klase']) ?>
                <a href="modifikim_instruktori.php?id=<?= $klasa['id_klase'] ?>">Modifiko</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>


