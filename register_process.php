
<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$validime_array=array();

$emri=mysqli_real_escape_string($conn, $_POST['emer']);
$mbiemri=mysqli_real_escape_string($conn, $_POST['mbiemer']);
$email=mysqli_real_escape_string($conn, $_POST['email']);
$password=mysqli_real_escape_string($conn, $_POST['password']);
$roli=$_POST['roli'];

   if (empty($emri)){
    $validime_array[]="Fusha per emrin duhet te plotesohet";}
    if (empty($mbiemri)){
    $validime_array[]="Fusha per mbiemrin duhet te plotesohet";}
    if (empty($email)){
    $validime_array[]="Fusha per email duhet te plotesohet";}
    if(empty($password)){
    $validime_array[]="Fusha per fjalekalimin duhet te plotesohet";}
    if (strlen($password) < 6 ){
    $validime_array[]="Fjalekalimi duhet te kete te pakten 6 karaktere";}

    
$sql1="SELECT emer FROM perdorues WHERE email= ? LIMIT 1";
$stmt=mysqli_prepare($conn, $sql1);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $emerTest);
mysqli_stmt_fetch($stmt);

if(!empty($emerTest)){
$validime_array[]="Ky perdorues tashme ekziston. Jeni te sigurt qe nuk jeni regjistruar?";
}

if(empty($validime_array)) {

    $sql="INSERT INTO perdorues (emer, mbiemer, email, fjalekalim, krijuar_ne) VALUES (?, ?, ?, ?, NOW() )";
    $password=password_hash($password, PASSWORD_BCRYPT);
    $stmt=mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $emri, $mbiemri, $email, $password, $krijuar_ne);
    if(mysqli_stmt_execute( $stmt)){
    echo "Ju u regjistruat me sukses!";
    } else{
    echo "ERROR: Nuk mund te ekzekutohej query: $sql. " . mysqli_error($conn);
    }

    } else {
        echo "<ul>";
        foreach($validime_array as $value){
        echo "<li style='color:red'>". $value . "</li>";
        }
        echo "</ul>";
        }

}

?>
