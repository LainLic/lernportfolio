<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['is_superuser'] == 0) {
    header('Location: index.html');
}

// Verbindungsdaten für die Datenbank
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Abfrage, um die Benutzerliste zu erhalten
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

// Abfrage, um die Dateiliste zu erhalten
$sql_files = "SELECT * FROM files";
$result_files = $conn->query($sql_files);

// Abfrage, um die Anzahl der Online-Benutzer zu erhalten
$sql_online_users = "SELECT COUNT(*) AS online_users FROM users WHERE is_online = 1";
$result_online_users = $conn->query($sql_online_users);

if ($result_online_users->num_rows > 0) {
    $row = $result_online_users->fetch_assoc();
    $online_users = $row['online_users'];
} else {
    $online_users = 0;
}

// Generiere die Statistiken-Ausgabe
$stats_output = "<p>Anzahl der Online-Benutzer: {$online_users}</p>";

// Generiere die Benutzerliste-Ausgabe
$user_list_output = "<table><thead><tr><th>ID</th><th>Benutzername</th><th>Email</th><th>Superuser</th></tr></thead><tbody>";

if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $user_list_output .= "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['email']}</td><td>{$row['is_superuser']}</td></tr>";
    }
}
$user_list_output .= "</tbody></table>";

// Generiere die Dateiliste-Ausgabe
$file_list_output = "<table><thead><tr><th>ID</th><th>Dateiname</th><th>Dateityp</th><th>Größe</th><th>Bemerkungen</th><th>Optionen</th></tr></thead><tbody>";

if ($result_files->num_rows > 0) {
    while ($row = $result_files->fetch_assoc()) {
        $file_list_output .= "<tr><td>{$row['id']}</td><td>{$row['file_name']}</td><td>{$row['file_type']}</td><td>{$row['file_size']}</td><td>{$row['remarks']}</td><td><button>Löschen</button></td></tr>";
    }
}
$file_list_output .= "</tbody></table>";

// Datei-Upload-Funktionalität
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hier den Code zum Hochladen von Dateien hinzufügen
    // (ähnlich wie in der ursprünglichen `upload.php`-Datei)
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Optionaler Link zu einer CSS-Datei -->
</head>
<body>
    <h1>Admin-Dashboard</h1>

    <!-- Statistiken -->
    <div class="stats">
        <h2>Statistiken</h2>
        <?php echo $stats_output; ?>
    </div>

    <!-- Benutzerliste -->
    <div class="user-list">
        <h2>Benutzerliste</h2>
        <?php echo $user_list_output; ?>
    </div>

    <!-- Dateiliste -->
    <div class="file-list">
        <h2>Dateiliste</h2>
        <?php echo $file_list_output; ?>
    </div>

    <!-- Datei-Upload-Formular -->
    <div class="upload-form">
        <h2>Datei hochladen</h2>
        <form action="adminDB2.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file_to_upload" id="file_to_upload">
            <button type="submit" name="submit">Datei hochladen</button>
        </form>
    </div>
    <!-- mainpage-->
    <nav>
        <a href="#">Home</a>
        <a href="#">Über uns</a>
        <a href="#">Kontakt</a>
        
            <a href="logout.php">Logout</a>
        
    </nav>
    <main>
        <section>
            <h2>Willkommen auf unserer Webseite</h2>
            <p>Hier finden Sie alle Informationen zu unserem Unternehmen und unseren Produkten.</p>
        </section>
        <section>
            <h2>Unsere Produkte</h2>
            <p>Entdecken Sie unser breites Angebot an hochwertigen Produkten für jeden Bedarf.</p>
            <button class="btn">Mehr erfahren</button>
        </section>
        <section>
            <h2>Unser Team</h2>
            <p>Lernen Sie unser kompetentes Team kennen und erfahren Sie mehr über unsere Expertise.</p>
            <button class="btn">Mehr erfahren</button>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Meine Webseite. Alle Rechte vorbehalten.</p>
    </footer>
</body>
</html>
