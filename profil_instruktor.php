<?php

session_start();

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'instruktor'){ 
    header("Location: login.html");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili i instruktorit</title>
    <style>

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            background-color: #343a40;
            color: #fff;
            padding: 15px 0;
            font-size: 26px;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        nav a {
            padding: 12px 22px;
            margin: 0 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #0056b3;
        }

        .profile-info {
            margin-top: 40px;
            text-align: center;
        }

        .profile-info p {
            font-size: 20px;
            margin: 12px 0;
        }

        .profile-info button {
            padding: 12px 24px;
            background-color: #ffc107;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .profile-info button:hover {
            background-color: #e0a800;
        }

        footer {
            text-align: center;
            margin-top: 180px;
            padding: 15px;
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

<header>
    Profil Instruktor
</header>

<br><br>
<br><br>
<br><br><br>

<div class="container">
    <nav>
        <a href="profil_instruktor.php">Profil</a>
        <a href="klasat.php">Klasat</a>
        <a href="mesazhe.php">Mesazhe</a>
        <a href="login.html">Logout</a>
    </nav>

    <div class="profile-info">
        <p>Mire se vini, instruktor!</p>
        <button>Edito informacionin</button>
    </div>
</div>

<footer>
    &copy; 2025 Fitness Center
</footer>

</body>
</html>

