<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Marrja e inputeve dhe verifikimi
    $token = $_POST['kodi_reset'];
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($token) || empty($newPassword)) {
        exit("Te dhenat jane te paplota.");
    }

    // Kontrollimi i token-it dhe afatit
    $stmt = $conn->prepare("
        SELECT p.email
        FROM rikuperim_fjalekalimi r
        JOIN perdorues p ON r.id_perdoruesi = p.id_perdoruesi
        WHERE r.kodi_reset = ? AND r.skadon_ne > NOW()
    ");

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        exit("Linku ka skaduar ose nuk eshte i vlefshem!");
    }

    $data = $result->fetch_assoc();
    $email = $data['email'];
    $stmt->close();

    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $update = $conn->prepare("UPDATE perdorues SET fjalekalim = ? WHERE email = ?");
    $update->bind_param("ss", $hashedPassword, $email);
    $success = $update->execute();
    $update->close();

    if (!$success) {
        exit("Gabim gjate ndryshimit te fjalekalimit.");
    }

    $delete = $conn->prepare("DELETE FROM rikuperim_fjalekalimi WHERE kodi_reset = ?");
    $delete->bind_param("s", $token);
    $delete->execute();
    $delete->close();

    echo "Fjalekalimi u ndryshua me sukses!";
}

?>
