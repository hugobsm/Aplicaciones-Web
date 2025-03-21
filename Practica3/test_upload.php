<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba de subida</title>
</head>
<body>

<h2>Subida de archivos</h2>
<form action="test_upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="archivo">
    <button type="submit" name="subir">Subir</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    if (isset($_FILES['archivo'])) {
        if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            echo "<p>✅ Archivo recibido: " . $_FILES['archivo']['name'] . "</p>";
        } else {
            echo "<p>❌ Error al subir el archivo: " . $_FILES['archivo']['error'] . "</p>";
        }
    } else {
        echo "<p>⚠️ No se ha recibido ningún archivo.</p>";
    }
}
?>

</body>
</html>
