<?php
session_start();
if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'klient') {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Klient</title>
    <style>

        body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

       
       .container {
            width: 55%;
            margin: 0 auto;
            margin-top: 140px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

         header {
            text-align: center;
            background-color: #28a745;
            color: #fff;
            padding: 10px 0;
            font-size: 24px;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        nav a {
            padding: 12px 18px;
            margin: 0 10px;
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        nav a:hover {
            background-color: #138496;
        }

        .profile-info {
            margin-top: 35px;
            text-align: center;
        }

        .profile-info p {
            font-size: 22px;
            margin: 15px 0;
        }

        .profile-info button {
            padding: 12px 26px;
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
            margin-top: 120px;
            padding: 15px;
            background-color: #28a745;
            color: white;
        }

    </style>
</head>
<body>

<header>
    Profil Klient
</header>


<div class="container">
    <nav>
        <a href="profil_klient.php">Profil</a>
        <a href="rezervimet.php">Rezervime</a>
        <a href="mesazhe.php">Mesazhe</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="profile-info">
        <p>Mire se vini, klient!</p>
        <button>Edito informacionin</button>
    </div>
</div>

<footer>
    &copy;2025 Fitness Center
</footer>

</body>
</html>
