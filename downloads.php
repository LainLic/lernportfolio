<?php
require_once 'db_connect.php';
session_start();

function download_file($file_id, $conn) {
    $sql = "SELECT * FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();

    if ($file) {
        $file_path = $file['file_path'];
        $file_name = $file['file_name'];

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
    } else {
        echo "File not found";
    }

    $stmt->close();
}

if (isset($_GET['id'])) {
    $file_id = $_GET['id'];
    download_file($file_id, $conn);
    exit();
}

?>
