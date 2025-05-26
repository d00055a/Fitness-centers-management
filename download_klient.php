
<?php

session_start();
if (!isset($_SESSION['roli']) || $_SESSION['roli'] !== 'klient') {
    header("Location: login.html");
    exit;
}

$folder = 'uploads/klient/';
$files = array_diff(scandir($folder), array('.', '..'));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shkarko dokumente - Klient</title>
    <style>

       body {
       padding: 0;
       font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
       background-color: #f0f4f8;
       min-height: 100vh;
       margin: 0;

   }
 

        .download-list {
        max-width: 100%;          
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
        word-break: break-word;
        margin-top: 20px;
   }

        .download-item {
        padding: 10px;
        border-bottom: 1px solid #ccc;
        font-size: 16px;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
  }

        .download-container {
        max-width: 100%;
        overflow-x: auto;
    }

      .container {
       width: 100%;
       max-width: 600px;
       margin: 60px auto;
       text-align: center;
  }

        h2 {
            
            color: #2d3436;
            margin-bottom: 30px;
            font-size: 22px;
            text-align: center;

        }


        ul {

            list-style-type: none;
            padding: 0;
            align-items: center;
            text-align: center;

        }

        li {
            background-color: #e8f0fe;
            margin-bottom: 15px;
            padding: 14px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        li:hover {
            background-color: #d0e3ff;
        }

        a {
            text-decoration: none;
            color: #1e88e5;
            font-weight: 500;
            font-size: 16px;
            flex-grow: 1;
        }

        a:hover {
            text-decoration: underline;
            color: #1565c0;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Dokumentet e ngarkuara</h2>

    <div class="download-container">
        <ul class="download-list">
            <?php foreach ($files as $file): ?>
                <li class="download-item">
                    <a href="<?= $folder . urlencode($file) ?>" download><?= htmlspecialchars($file) ?></a>
                    
                     <form method="post" action="fshi_dokument.php" style="display:inline;">
        <input type="hidden" name="file_to_delete" value="<?= htmlspecialchars($file) ?>">
        <input type="hidden" name="folder" value="<?= $folder ?>">
        <button type="submit" onclick="return confirm('Jeni i sigurt qe doni ta fshini kete dokument?');" style="margin-left: 10px; background-color:#dc3545; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">Fshi</button>
                     </form>
                     
                </li> 
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>

</html>
