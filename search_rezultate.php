
<?php

include 'config.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

echo "<h2>Rezultatet e kerkimit per: <em>" . htmlspecialchars($query) . "</em></h2>";

if ($type == 'klasa') {
    $stmt = $conn->prepare("SELECT * FROM Klasa WHERE emer_klase LIKE ?");
    $like = "%$query%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($rresht = $result->fetch_assoc()) {
        echo "<p><strong>Klasa:</strong> " . htmlspecialchars($rresht['emer_klase']) . "</p>";
    }

} elseif ($type == 'perdorues') {
    $stmt = $conn->prepare("SELECT * FROM Perdorues WHERE emer LIKE ? OR mbiemer LIKE ?");
    $like = "%$query%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($rresht = $result->fetch_assoc()) {
        echo "<p><strong>Perdorues:</strong> " . htmlspecialchars($rresht['emer']) . " " . htmlspecialchars($rresht['mbiemer']) . "</p>";
    }

} elseif ($type == 'dokument') {
    $stmt = $conn->prepare("SELECT * FROM Dokumente WHERE emer_file LIKE ?");
    $like = "%$query%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($rresht = $result->fetch_assoc()) {
        echo "<p><strong>Dokument:</strong> " . htmlspecialchars($rresht['emer_file']) . "</p>";
    }

} else {
    echo "<p>Tipi i kerkimit nuk eshte i vlefshem.</p>";
}

$conn->close();

?>
