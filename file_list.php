<?php
require_once 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
}

$sql = "SELECT * FROM files";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Dateiliste</title>
</head>
<body>
    <h1>Dateiliste</h1>
    <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <a href="download.php?id=<?php echo $row['id']; ?>"><?php echo $row['file_name']; ?></a>
        </li>
    <?php endwhile; ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>
