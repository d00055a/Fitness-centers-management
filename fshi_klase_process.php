<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $klasa = $_POST['id_klase'];

    $stmt1 = $conn->prepare("DELETE FROM Orare WHERE id_klase = ?");
    $stmt1->bind_param("i", $klasa);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $conn->prepare("DELETE FROM Klasa WHERE id_klase = ?");
    $stmt2->bind_param("i", $klasa);

    if ($stmt2->execute()) {
        echo "Klasa u fshi me sukses!";
    } else {
        echo "Gabim gjate fshirjes se klases.";
    }

    $stmt2->close();
    $conn->close();

}

?>