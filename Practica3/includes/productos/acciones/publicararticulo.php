<?php
session_start();
// Conexión a la base de datos
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "brandswap";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_producto = $_POST['nombre_producto'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $id_usuario = $_SESSION['id_usuario'];
    $fecha_publicacion = date("Y-m-d H:i:s");

    // Manejo de la imagen
    $nombre_imagen = "default.jpg"; // Imagen por defecto
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio_subida = "uploads/";
        $nombre_imagen = time() . "_" . basename($_FILES["imagen"]["name"]);
        $ruta_imagen = $directorio_subida . $nombre_imagen;

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagen)) {
            $nombre_imagen = "default.jpg"; // Si hay error, usa la imagen por defecto
        }
    }

    // Insertar en la base de datos
    $query = "INSERT INTO productos (id_usuario, nombre_producto, descripcion, precio, imagen, fecha_publicacion) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issdss", $id_usuario, $nombre_producto, $descripcion, $precio, $nombre_imagen, $fecha_publicacion);

    if ($stmt->execute()) {
        echo "<script>alert('Artículo publicado con éxito'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error al publicar el artículo');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Artículo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="file"] {
            display: none;
        }
        label {
            display: inline-block;
            background-color: black;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        label:hover {
            background-color: gray;
        }
        button {
            background: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: gray;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Publicar Artículo</h1>
    <form action="publicararticulo.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre_producto" placeholder="Nombre del producto" required>
        <textarea name="descripcion" placeholder="Descripción" required></textarea>
        <input type="number" name="precio" placeholder="Precio" step="0.01" required>

        <!-- Botón personalizado para subir una foto -->
        <label for="imagen">Seleccionar una foto</label>
        <input type="file" name="imagen" id="imagen" accept="image/*">
        <span id="nombreArchivo">Ningún archivo seleccionado</span>

        <button type="submit">Publicar</button>
    </form>
</div>

<script>
    document.getElementById("imagen").addEventListener("change", function() {
        let archivo = this.files[0] ? this.files[0].name : "Ningún archivo seleccionado";
        document.getElementById("nombreArchivo").textContent = archivo;
    });
</script>

</body>
</html>
