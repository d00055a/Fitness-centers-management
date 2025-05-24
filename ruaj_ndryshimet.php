<?php
session_start();
include 'config.php';

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'instruktor') {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_klase = $_POST['id_klase'];
    $emer_klase = $_POST['emer_klase'];
    $pershkrimi = $_POST['pershkrimi'];

    // Përditëso klasën
    $sql = "UPDATE Klasa SET emer_klase = ?, pershkrimi = ? WHERE id_klase = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $emer_klase, $pershkrimi, $id_klase);
    $stmt->execute();

    // Shto klientë në klasë
    if (!empty($_POST['shto_kliente'])) {
        foreach ($_POST['shto_kliente'] as $id_klient) {
            $sql = "INSERT INTO Rezervime (id_klienti, id_klase, date_rezervimi, statusi)
                    VALUES (?, ?, CURDATE(), 'aktiv')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id_klient, $id_klase);
            $stmt->execute();
        }
    }

    // Hiq klientë nga klasa
    if (!empty($_POST['hiq_kliente'])) {
        foreach ($_POST['hiq_kliente'] as $id_klient) {
            $sql = "DELETE FROM Rezervime WHERE id_klienti = ? AND id_klase = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id_klient, $id_klase);
            $stmt->execute();
        }
    }

    header("Location: klasa_instruktor.php");
    exit;
}
?>
