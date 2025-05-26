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
    $dita = $_POST['dita'];
    $ora_fillimit = $_POST['ora_fillimit'];
    $ora_mbarimit = $_POST['ora_mbarimit'];

    $sql_update_klasa = "UPDATE Klasa SET emer_klase = ?, pershkrimi = ? WHERE id_klase = ?";
    $stmt = $conn->prepare($sql_update_klasa);
    $stmt->bind_param("ssi", $emer_klase, $pershkrimi, $id_klase);
    $stmt->execute();
    $stmt->close();

    $id_instruktor = $_SESSION['id_perdoruesi'];

    $check_sql = "SELECT id_orari FROM Orare WHERE id_klase = ? AND dita = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("is", $id_klase, $dita);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {

        $sql_orari = "UPDATE Orare SET ora_fillimit = ?, ora_mbarimit = ? WHERE id_klase = ? AND dita = ?";
        $stmt = $conn->prepare($sql_orari);
        $stmt->bind_param("ssis", $ora_fillimit, $ora_mbarimit, $id_klase, $dita);

    } else {

        $sql_orari = "INSERT INTO Orare (id_klase, dita, ora_fillimit, ora_mbarimit)
                      VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_orari);
        $stmt->bind_param("isss", $id_klase, $dita, $ora_fillimit, $ora_mbarimit);
    }
    $stmt->execute();
    $stmt->close();
    $stmt_check->close();

    if (!empty($_POST['shto_kliente'])) {
        foreach ($_POST['shto_kliente'] as $id_klient) {
            $sql_shto = "INSERT INTO Rezervime (id_klienti, id_klase, date_rezervimi, statusi)
                         VALUES (?, ?, CURDATE(), 'aktiv')";
            $stmt = $conn->prepare($sql_shto);
            $stmt->bind_param("ii", $id_klient, $id_klase);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (!empty($_POST['hiq_kliente'])) {
        foreach ($_POST['hiq_kliente'] as $id_klient) {
            $sql_fshi = "DELETE FROM Rezervime WHERE id_klienti = ? AND id_klase = ?";
            $stmt = $conn->prepare($sql_fshi);
            $stmt->bind_param("ii", $id_klient, $id_klase);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: klasa_instruktor.php");
    exit;
}
?>
