<?php 

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $validime_array = [];

    $emri = mysqli_real_escape_string($conn, $_POST['emer']);
    $mbiemri = mysqli_real_escape_string($conn, $_POST['mbiemer']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $roli = $_POST['roli'];

    if (empty($emri)) $validime_array[] = "Fusha per emrin duhet te plotesohet";
    if (empty($mbiemri)) $validime_array[] = "Fusha per mbiemrin duhet te plotesohet";
    if (empty($email)) $validime_array[] = "Fusha per email duhet te plotesohet";
    if (empty($password)) $validime_array[] = "Fusha per fjalekalimin duhet te plotesohet";
    if (strlen($password) < 6) $validime_array[] = "Fjalekalimi duhet te ketete pakten 6 karaktere.";

    // Kontrollo nëse ekziston email-i
    $sql1 = "SELECT email FROM perdorues WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result( $stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $validime_array[] = "Ky perdorues tashme ekziston. Jeni te sigurte qe nuk jeni te regjistruar?";
    }

    if (empty($validime_array)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql_insert_perdorues = "INSERT INTO perdorues (emer, mbiemer, email, fjalekalim, krijuar_ne) VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql_insert_perdorues);
        mysqli_stmt_bind_param($stmt, "ssss", $emri, $mbiemri, $email, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            $id_perdoruesi = mysqli_insert_id($conn); 

            
            $sql_insert_roli = "INSERT INTO roli (emer_roli, id_perdoruesi) VALUES (?, ?)";
            $stmt2 = mysqli_prepare($conn, $sql_insert_roli);
            mysqli_stmt_bind_param($stmt2, "si", $roli, $id_perdoruesi);
            
            if (mysqli_stmt_execute($stmt2)) {
                echo "Ju u regjistruat me sukses!";
            } else {
                echo "Gabim gjate zgjedhjes se rolit: " . mysqli_error($conn);
            }

        } else {
            echo "Gabim gjate regjistrimit: " . mysqli_error($conn);
        }

    } else {
        echo "<ul>";
        foreach ($validime_array as $value) {
            echo "<li style='color:red'>" . $value . "</li>";
        }
        echo "</ul>";
    }

} else {
    http_response_code(405);
    echo "Metode jo e lejuar.";
}

mysqli_close($conn);
?>
