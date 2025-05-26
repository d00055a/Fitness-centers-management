<?php

session_start();
include 'config.php';

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'instruktor') {
    header("Location: login.html");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID e klasës nuk është dhënë.";
    exit;
}

$id_klase = $_GET['id'];
$id_instruktor = $_SESSION['id_perdoruesi'];

$sql = "SELECT * FROM Klasa WHERE id_klase = ? AND id_instruktori = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_klase, $id_instruktor);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Klasë jo e vlefshme ose nuk keni akses.";
    exit;
}

$klasa = $result->fetch_assoc();

$sql = "SELECT id_perdoruesi, emer, mbiemer FROM Perdorues 
        WHERE id_perdoruesi NOT IN (
            SELECT id_klienti FROM Rezervime WHERE id_klase = ?
        ) AND id_perdoruesi IN (
            SELECT id_perdoruesi FROM Roli WHERE emer_roli = 'klient'
        )";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_klase);
$stmt->execute();
$klientet_disponueshem = $stmt->get_result();

$sql = "SELECT P.id_perdoruesi, P.emer, P.mbiemer 
        FROM Perdorues P
        INNER JOIN Rezervime R ON P.id_perdoruesi = R.id_klienti
        WHERE R.id_klase = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_klase);
$stmt->execute();
$klientet_regjistruar = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifiko klasen</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f8;
            
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #444;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        h3 {
            margin-top: 25px;
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        .checkbox-list {
            margin-top: 10px;
            line-height: 1.8;
        }

        input[type="submit"] {
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Modifiko klasen: <?= htmlspecialchars($klasa['emer_klase']) ?></h2>

    <form action="ruaj_ndryshimet.php" method="post">
        <input type="hidden" name="id_klase" value="<?= $id_klase ?>">

        <label for="emer_klase">Emri i ri i klases:</label>
        <input type="text" name="emer_klase" value="<?= htmlspecialchars($klasa['emer_klase']) ?>">

        <label for="pershkrimi">Pershkrimi:</label><br>
        <textarea name="pershkrimi" rows="4" cols="40"><?= htmlspecialchars($klasa['pershkrimi']) ?></textarea>

        <label for="dita">Dita:</label>
        <select name="dita" required>
       <option value="">Zgjidhni diten</option>
    <option value="E Hene">E hene</option>
    <option value="E Marte">E marte</option>
    <option value="E Merkure">E merkure</option>
    <option value="E Enjte">E enjte</option>
    <option value="E Premte">E premte</option>
    <option value="E Shtune">E shtune</option>
    <option value="E Diele">E diele</option>
</select>

<label for="ora_fillimit">Ora Fillimit:</label>
<input type="time" name="ora_fillimit" required>

<label for="ora_mbarimit">Ora Mbarimit:</label>
<input type="time" name="ora_mbarimit" required>

        <h3>Shto kliente ne klase:</h3>
        <?php while ($klient = $klientet_disponueshem->fetch_assoc()): ?>
            <input type="checkbox" name="shto_kliente[]" value="<?= $klient['id_perdoruesi'] ?>">
            <?= htmlspecialchars($klient['emer'] . ' ' . $klient['mbiemer']) ?>
        <?php endwhile; ?>

        <h3>Hiq kliente nga klasa:</h3>
        <?php while ($klient = $klientet_regjistruar->fetch_assoc()): ?>
            <input type="checkbox" name="hiq_kliente[]" value="<?= $klient['id_perdoruesi'] ?>">
            <?= htmlspecialchars($klient['emer'] . ' ' . $klient['mbiemer']) ?>
        <?php endwhile; ?>

        
        <input type="submit" value="Ruaj ndryshimet">
    </form>
</body>
</html>
