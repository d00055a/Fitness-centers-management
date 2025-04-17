
<?php

$emriServer="localhost";
$username="root";
$password="";
$db="qender_fitnesi_db";

$conn=mysqli_connect($emriServer, $username, $password, $db);

if(!$conn){

echo "Problem me lidhjen ".mysqli_connect_errno();

exit;

}



?>