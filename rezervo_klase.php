<!DOCTYPE html>
<html>
<head>
    <title>Rezervo Klasë</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef1f5;
            text-align: center;
        }

        h2 {
            margin-top: 30px;
        }

        form {
            margin: 30px auto;
            width: 60%;
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        select, button {
            padding: 10px;
            margin-top: 15px;
            font-size: 16px;
            width: 80%;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .info {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
<br><br>
<br><br>
<br><br>

<h2>Rezervoni nje klase</h2>

<form action="rezervo_process.php" method="POST">
    <label for="id_klase">Zgjidhni klasen:</label><br>
    <select name="id_klase" required>
        <?php
        include 'config.php';
        session_start();

        if (!isset($_SESSION['id_perdoruesi']) || $_SESSION['roli'] !== 'klient') {
            header("Location: login.html");
            exit;
        }

        $sql = "SELECT k.id_klase, k.emer_klase, k.kapaciteti_max, o.dita, o.ora_fillimit, o.ora_mbarimit 
                FROM Klasa k 
                LEFT JOIN Orare o ON k.id_klase = o.id_klase";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id_klase'].'">'.
                    htmlspecialchars($row['emer_klase']) . ' - ' .
                    $row['dita'] . ' [' . $row['ora_fillimit'] . ' - ' . $row['ora_mbarimit'] . ']'.
                 '</option>';
        }

        $conn->close();

        ?>

    </select><br><br>

    <button type="submit">Rezervo</button>
</form>

</body>
</html>
