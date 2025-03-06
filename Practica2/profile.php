<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Asegurar que la imagen de perfil tenga un valor predeterminado
$foto_perfil = $_SESSION['foto_perfil'] ?? 'uploads/default-avatar.png';

// Asegurar que la fecha de registro no sea null
$fecha_registro = $_SESSION['fecha_registro'] ?? 'No disponible';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .profile-container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #333;
            margin-bottom: 15px;
        }
        .buttons-container {
            margin-top: 20px;
        }
        .add-button, .view-products-button {
            padding: 10px 20px;
            margin: 5px;
            background-color: black;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .add-button:hover, .view-products-button:hover {
            background-color: #333;
        }
        .view-products-button {
            background-color: #007bff;
        }
        .view-products-button:hover {
            background-color: #0056b3;
        }
        .logout {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background: darkred;
        }
    </style>
</head>
<body>

<?php
$contenidoPrincipal = "
    <div class='profile-container'>
        <h1>Bienvenido, " . htmlspecialchars($_SESSION['nombre']) . "!</h1>
        <img src='" . htmlspecialchars($_SESSION['foto_perfil']) . "' alt='Foto de perfil' class='profile-img'>
        <p>Email: " . htmlspecialchars($_SESSION['email']) . "</p>
        <p>Fecha de Registro: " . htmlspecialchars($_SESSION['fecha_registro']) . "</p>
        <div class='buttons-container'>
            <a href='publicararticulo.php' class='add-button'>Añadir producto</a>
            <a href='verProductos.php' class='view-products-button'>Ver mis productos</a>
        </div>
        <a href='logout.php' class='logout'>Cerrar Sesión</a>
    </div>
";

require("includes/vistas/plantilla/plantilla.php");
?>
</body>
</html>
