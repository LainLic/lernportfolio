<?php
require_once 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
}

function getPreviewLink($file_path) {
    $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);

    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        return "thumbnail.php?file=" . urlencode($file_path);
    } elseif ($file_ext === 'pdf') {
        return "pdfjs/web/viewer.html?file=" . urlencode("http://localhost:80/downloadsite/" . $file_path);
    } elseif (in_array($file_ext, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'])) {
        return "https://docs.google.com/viewer?url=" . urlencode("http://localhost:80/downloadsite/" . $file_path);
    }

    return ''; // fallback for unsupported file types
}




$sql_files = "SELECT * FROM files";
$result_files = $conn->query($sql_files);

// Generiere die Dateiliste-Ausgabe
$file_list_output = "<table><thead><tr><th>Dateiname</th><th>Bemerkung</th><th>Optionen</th></tr></thead><tbody>";

if ($result_files->num_rows > 0) {
    while ($row = $result_files->fetch_assoc()) {
        $file_path = 'uploads/' . $row['file_path'];
        $preview_link = getPreviewLink($file_path);
        
        // Neue Zeile mit Vorschau
        $file_list_output .= "<tr>
        <td class='file-preview' data-filepath='{$file_path}'><span>{$row['file_name']}</span></td>
        <td>{$row['remarks']}</td>
        <td><a href='download.php?id={$row['id']}'>Herunterladen</a>";

        if ($preview_link) {
            $file_list_output .= " | <a href='{$preview_link}' target='_blank'>Vorschau</a>";
        }

        $file_list_output .= "</td></tr>";
    }
}



$file_list_output .= "</tbody></table>";

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Meine Webseite</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<h1>Meine Webseite</h1>
	</header>
	<nav>
		<a href="#">Home</a>
		<a href="#">Über uns</a>
		<a href="#">Kontakt</a>
		<div>
            <?php if ($_SESSION['is_superuser'] == 1): ?>
            <a href="adminDB.php">Admin Dashboard</a>
            <?php endif; ?>
			<a href="logout.php">Logout</a>
		</div>
	</nav>
	<main>
		<section>
			<h2>Willkommen auf unserer Webseite</h2>
			<p>Hier finden Sie alle Informationen zu unserem Unternehmen und unseren Produkten.</p>
		</section>
		<section>
			<h2>Unsere Produkte</h2>
			<p>Entdecken Sie unser breites Angebot an hochwertigen Produkten für jeden Bedarf.</p>
			<div class="table">
            <?php echo $file_list_output; ?>
            </div>
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
	<script src="script.js"></script>
</body>
</html>
