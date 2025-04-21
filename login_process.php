
<?php

session_start();

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['fjalekalim']);

    $sql = "SELECT p.id_perdoruesi, p.fjalekalim, r.emer_roli 
            FROM Perdorues p 
            JOIN Roli r ON p.id_perdoruesi = r.id_perdoruesi
            WHERE p.email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['fjalekalim'])) {
            $_SESSION['id_perdoruesi'] = $row['id_perdoruesi'];
            $_SESSION['roli'] = $row['emer_roli'];
            echo "Sukses! Po ridrejtohesh si " . strtolower($row['emer_roli']); 
        } else {
            echo "Gabim: Fjalekalim i pasakte!";
        }
    } else {
        echo "Gabim: Emaili nuk ekziston!";
    }

} else {
    http_response_code(405);
    echo "Metode jo e lejuar.";
}
?>
