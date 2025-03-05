<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";  // Servidor de la base de datos
$username = "root";  // Usuario de MySQL (por defecto en XAMPP)
$password = "";  // Contraseña (vacía por defecto en XAMPP)
$dbname = "brandswap";  // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $contrasena = trim($_POST["contrasena"]);

    // Buscar el usuario en la base de datos
    $sql = "SELECT id_usuario, nombre, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Si se encuentra el usuario
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $nombre, $hash_contrasena);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($contrasena, $hash_contrasena)) {
            $_SESSION["login"] = true;
            $_SESSION["id_usuario"] = $id_usuario;
            $_SESSION["nombre"] = $nombre;
            $_SESSION["email"] = $email;
            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña ingresada: " . $contrasena . "<br>";
echo "Hash en BD: " . $hash_contrasena . "<br>";
            $error = "⚠️ Contraseña incorrecta.";
        }
    } else {
        $error = "⚠️ Usuario no encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
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
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required><br><br>

            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>

</body>
</html>
