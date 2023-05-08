<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($result->num_rows > 0 && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_superuser'] = $user['is_superuser'];
        
        if ($user['is_superuser'] == 1) {
            header("Location: adminDB.php");
        } else {
            header("Location: home.php");
        }
    } else {
        echo "Ungültiger Benutzername oder Passwort.";
    }

    $stmt->close();
    $conn->close();
}
?>
