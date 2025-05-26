<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_perdoruesi']) || $_SESSION['roli'] !== 'klient') {
    header("Location: login.html");
    exit;
}

$id_klienti = $_SESSION['id_perdoruesi'];
$id_klase = $_POST['id_klase'];

$sql_check = "SELECT * FROM Rezervime WHERE id_klienti = ? AND id_klase = ? AND statusi = 'aktiv'";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_klienti, $id_klase);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "Ju jeni tashme te regjistruar ne kete klase!";
    exit;
}

$sql_count = "SELECT COUNT(*) as total FROM Rezervime WHERE id_klase = ? AND statusi = 'aktiv'";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $id_klase);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$row_count = $result_count->fetch_assoc();
$rezervime_aktuale = $row_count['total'];

$sql_kapacitet = "SELECT kapaciteti_max FROM Klasa WHERE id_klase = ?";
$stmt_kapacitet = $conn->prepare($sql_kapacitet);
$stmt_kapacitet->bind_param("i", $id_klase);
$stmt_kapacitet->execute();
$result_kapacitet = $stmt_kapacitet->get_result();
$row_kapacitet = $result_kapacitet->fetch_assoc();
$kapaciteti_max = $row_kapacitet['kapaciteti_max'];

if ($rezervime_aktuale >= $kapaciteti_max) {
    echo "Nuk ka me vende te lira per kete klase.";
    exit;
}

$sql_insert = "INSERT INTO Rezervime (id_klienti, id_klase, date_rezervimi, statusi) 
               VALUES (?, ?, CURDATE(), 'aktiv')";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ii", $id_klienti, $id_klase);

if ($stmt_insert->execute()) {
    echo "Rezervimi u krye me sukses!";
} else {
    echo "Gabim gjate rezervimit.";
}

$conn->close();
?>
