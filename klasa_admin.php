<?php
session_start();
include 'config.php';

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'admin') {
    header("Location: login.html");
    exit;
}

$result = $conn->query("SELECT * FROM klasa");
?>

<!DOCTYPE html>
<html>
<head><title>Menaxho Klasat</title>
<style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 20px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eef3fb;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-add {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-add:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<h2>Klasat</h2>
<table border="1">
    <tr><th>Emri</th><th>Pershkrimi</th><th>Veprime</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['emer_klase'] ?></td>
        <td><?= $row['pershkrimi'] ?></td>
        <td>
            <a href="fshi_klase.html?id=<?= $row['id_klase'] ?>">Fshi</a> |
            <a href="edito_klase.html?id=<?= $row['id_klase'] ?>">Edito</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="shto_klase.html">Shto Klase</a>
</body>
</html>
