<?php
include 'config.php';
session_start();

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'admin') {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $klasa = $_POST['id_klase'];
    $emri = $_POST['emer_klase'];
    $pershkrimi = $_POST['pershkrimi'];
    $instruktori = $_POST['id_instruktori'];
    $kapaciteti = $_POST['kapaciteti_max'];

    
    $dita = $_POST['dita'];
    $ora_fillimit = $_POST['ora_fillimit'];
    $ora_mbarimit = $_POST['ora_mbarimit'];

    $stmt = $conn->prepare("UPDATE klasa SET emer_klase = ?, pershkrimi = ?, id_instruktori = ?, shtuar_ne = NOW(), kapaciteti_max = ? WHERE id_klase = ?");
    $stmt->bind_param("ssiii", $emri, $pershkrimi, $instruktori, $kapaciteti, $klasa);
    $stmt->execute();
    $stmt->close();

    $conn->query("DELETE FROM Orare WHERE id_klase = $klasa");

    $stmt2 = $conn->prepare("INSERT INTO Orare (id_klase, dita, ora_fillimit, ora_mbarimit) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("isss", $klasa, $dita, $ora_fillimit, $ora_mbarimit);
    $stmt2->execute();
    $stmt2->close();

    echo "Klasa dhe orari u përditësuan me sukses!";
    $conn->close();
}

?>
