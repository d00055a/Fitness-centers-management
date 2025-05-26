<?php
include 'config.php';
session_start();

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'admin') {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emri = $_POST['emer_klase'];
    $pershkrimi = $_POST['pershkrimi'];
    $instruktori = $_POST['id_instruktori'];
    $kapaciteti = $_POST['kapaciteti_max'];

    $dita = $_POST['dita'];
    $ora_fillimit = $_POST['ora_fillimit'];
    $ora_mbarimit = $_POST['ora_mbarimit'];

    $stmt = $conn->prepare("INSERT INTO Klasa (emer_klase, pershkrimi, id_instruktori, shtuar_ne, kapaciteti_max) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("ssii", $emri, $pershkrimi, $instruktori, $kapaciteti);

    if ($stmt->execute()) {
        $id_klase = $stmt->insert_id;

        $stmt2 = $conn->prepare("INSERT INTO Orare (id_klase, dita, ora_fillimit, ora_mbarimit) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("isss", $id_klase, $dita, $ora_fillimit, $ora_mbarimit);
        $stmt2->execute();
        $stmt2->close();

        echo "Klasa dhe orari u shtuan me sukses!";
    
    } else {
        echo "Gabim gjate shtimit te klases.";
    }

    $stmt->close();
    $conn->close();
}

?>
