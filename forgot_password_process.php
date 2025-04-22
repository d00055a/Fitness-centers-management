
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM perdorues WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $kodi_reset = bin2hex(random_bytes(32));

        $row = $result->fetch_assoc();
         $id_perdoruesi = $row['id_perdoruesi'];

         $kohaSkadimit = date("Y-m-d H:i:s", strtotime("+10 minutes"));

     $sqlInsert = "INSERT INTO rikuperim_fjalekalimi (id_perdoruesi, kodi_reset, skadon_ne) VALUES (?, ?, ?)";
     $stmtInsert = $conn->prepare($sqlInsert);
     $stmtInsert->bind_param("iss", $id_perdoruesi, $kodi_reset, $kohaSkadimit);

        $stmtInsert->execute();

        $link = "http://localhost/php-prac/reset_password.html?kodi_reset=" . urlencode($kodi_reset);

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'danieldedja2@gmail.com';  
            $mail->Password = 'jflydrhgyhabylcn';           
            $mail->SMTPSecure = 'tls';                 
            $mail->Port = 587;

            $mail->setFrom('danieldedja2@gmail.com', 'FitTech');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Rivendos fjalekalimin - FitTech';
            $mail->Body = "Per te ndryshuar fjalekalimin, klikoni linkun me poshte:<br><a href='$link'>$link</a>";

            $mail->send();
            echo "Email-i u dergua me sukses. Kontrollo email-in per te rivendosur fjalekalimin.";
        } catch (Exception $e) {
            echo "Gabim gjate dergimit te emailit: {$mail->ErrorInfo}";
        }

    } else {
        echo "Emaili nuk ekziston ne sistem!";
    }

    $stmt->close();
    $conn->close();

} else {
    http_response_code(405);
    echo "Metode jo e lejuar.";
}
?>