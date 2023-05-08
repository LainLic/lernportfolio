<?php
// Dateipfad zum Originalbild
$file = $_SERVER['DOCUMENT_ROOT'] . '/downloadsite/uploads/' . basename($_GET['file']);


// Maximale Abmessungen des Vorschaubilds
$maxWidth = 200;
$maxHeight = 200;

// Erstelle ein neues Bild-Objekt aus der Originaldatei
$image = imagecreatefromstring(file_get_contents($file));

// Bestimme die Größe des Originalbildes
$width = imagesx($image);
$height = imagesy($image);

// Bestimme das Verhältnis zwischen Breite und Höhe
$ratio = $width / $height;

// Bestimme die neue Breite und Höhe des Vorschaubildes
if ($maxWidth / $maxHeight > $ratio) {
    $newWidth = $maxHeight * $ratio;
    $newHeight = $maxHeight;
} else {
    $newWidth = $maxWidth;
    $newHeight = $maxWidth / $ratio;
}

// Erstelle ein neues Bild-Objekt mit der neuen Größe
$newImage = imagecreatetruecolor($newWidth, $newHeight);

// Kopiere das Originalbild in das neue Bild-Objekt und skaliere es
imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

// Gib das neue Bild aus
header('Content-Type: image/jpeg');
imagejpeg($newImage);
