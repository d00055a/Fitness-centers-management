<?php
session_start();

if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'admin') {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili i administratorit</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            font-size: 24px;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        nav a {
            padding: 10px 20px;
            margin: 0 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        nav a:hover {
            background-color: #0056b3;
        }

        .profile-info {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-info p {
            font-size: 22px;
            margin: 10px 0;
        }

        .profile-info button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-info button:hover {
            background-color: #218838;
        }

        footer {
            text-align: center;
            margin-top: 150px;
            padding: 10px;
            background-color: #333;
            color: white;
        }

         button{
            cursor: pointer;
        }
        
    </style>
</head>
<body>

<header>
    Profil Admin
</header>

<br><br>
<br><br>
<br><br><br>

<div class="container">
    <nav>
        <a href="profil_admin.php">Profil</a>
        <a href="klasa_admin.php">Klasat</a>
        <a href="upload_admin.php">Ngarko dokumente</a>
        <a href="download_admin.php">Shiko dokumentet</a>
        <a href="mesazhe.php">Mesazhe</a>
        <a href="login.html">Logout</a>
    </nav>

   <div style="margin-top: 30px; margin-left: 23%;">
    <form method="GET" action="search_rezultate.php">
        <input type="text" name="query" placeholder="Kerko..." required style="padding: 8px; width: 250px;">
        <select name="type" style="padding: 8px;">
            <option value="klasa">Klasa</option>
            <option value="perdorues">Perdorues</option>
            <option value="dokument">Dokument</option>
        </select>
        <button type="submit" style="padding: 8px 14px;">Kerko</button>
     </form>
  </div>
    <div class="profile-info">
        <p>Mire se vini ne profilin tuaj, admin!</p>
        <button>Edito informacionin</button>
    </div>
</div>

<footer>
    &copy; 2025 Fitness Center
</footer>

</body>
</html>
