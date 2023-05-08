<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website"; // Ersetze dies durch den Namen deiner Datenbank

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$admin_username = "admin";//benutzername des admins
$admin_password = "öüäüöä9"; // Ersetze dies durch das gewünschte Passwort für den Admin
$admin_email = "alain.lilic@gmail.com";//email des admins
$hashed_admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
$is_superuser = 1;

$sql = "INSERT INTO users (username, password, email, is_superuser) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $admin_username, $hashed_admin_password, $admin_email, $is_superuser);
$result = $stmt->execute();

if ($result) {
    echo "Admin-Benutzer erfolgreich erstellt.";
} else {
    echo "Fehler beim Erstellen des Admin-Benutzers: " . $conn->error;
}

$stmt->close();
$conn->close();

?>
