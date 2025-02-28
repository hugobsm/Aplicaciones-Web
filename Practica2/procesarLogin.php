<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Primera página dinámica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();

        $username = htmlspecialchars(trim(strip_tags($_REQUEST["nombre"] ?? "")));
        $password = htmlspecialchars(trim(strip_tags($_REQUEST["password"] ?? "")));

        if ($username === "nombre" && $password === "userpass") {
            $_SESSION["login"] = true;
            $_SESSION["nombre"] = "Usuario";
        } elseif ($username === "admin" && $password === "adminpass") {
            $_SESSION["login"] = true;
            $_SESSION["nombre"] = "Administrador";
            $_SESSION["esAdmin"] = true;
        }

        if (!isset($_SESSION["login"])) {
            echo "<h1>Error</h1><p>El usuario o contraseña no son válidos.</p>";
        } else {
            echo "<h1>Bienvenido, {$_SESSION['nombre']}!</h1><p>Usa el menú de la izquierda para navegar.</p>";
        }
        ?>
    </div>
</body>
</html>
