<?php
session_start();
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
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #333;
            margin-bottom: 15px;
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
    <div class="profile-container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
        <img src="<?php echo $_SESSION['profile_pic'] ?? 'default-avatar.png'; ?>" alt="Foto de perfil" class="profile-img">
        <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p>Fecha de Registro: <?php echo htmlspecialchars($_SESSION['register_date']); ?></p>
        <a href="logout.php" class="logout">Cerrar Sesión</a>
    </div>
</body>
</html>
<?php
require("includes/vistas/plantilla/plantilla.php");


