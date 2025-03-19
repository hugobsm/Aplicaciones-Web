<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brandswap";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $contrasena = password_hash(trim($_POST["contrasena"]), PASSWORD_DEFAULT); // Encripta la contraseña

    // Manejar la imagen de perfil
    $foto_perfil = "uploads/default-avatar.png"; // Imagen por defecto
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $imagen = $_FILES['foto_perfil'];
        $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $extensiones_permitidas)) {
            if (!is_dir("uploads/")) {
                mkdir("uploads/", 0777, true);
            }
            $nombre_imagen = "uploads/" . uniqid("perfil_") . "." . $extension;
            move_uploaded_file($imagen['tmp_name'], $nombre_imagen);
            $foto_perfil = $nombre_imagen;
        }
    }

    // Insertar el usuario en la base de datos con la foto de perfil
    $sql = "INSERT INTO usuarios (nombre, email, contrasena, foto_perfil, fecha_registro) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $contrasena, $foto_perfil);

    if ($stmt->execute()) {
        echo "<p>Registro exitoso. <a href='login.php'>Iniciar sesión</a></p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin-top: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Registro de usuario</h2>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        <form method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required><br><br>

            <label for="foto_perfil">Foto de Perfil:</label>
            <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*"><br><br>

            <input type="submit" value="Registrar">
        </form>
    </div>

</body>
</html>
