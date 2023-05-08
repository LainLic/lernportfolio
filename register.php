<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    if ($password !== $password_confirm) {
        echo "Die eingegebenen Passwörter stimmen nicht überein. Bitte versuchen Sie es erneut.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            echo "Registrierung erfolgreich. <a href='login.html'>Hier klicken, um sich anzumelden.</a>";
        } else {
            echo "Registrierung fehlgeschlagen. Bitte versuchen Sie es später noch einmal.";
        }
        $stmt->close();
    }
}
$conn->close();
?>
