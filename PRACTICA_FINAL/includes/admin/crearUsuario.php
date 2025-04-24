<?php
require_once __DIR__ . '/../usuario/userDAO.php';
require_once __DIR__ . '/../usuario/userDTO.php';
require_once __DIR__ . '/../comun/cabecera.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];

    $userDAO = new userDAO();

    $nuevoUsuario = new userDTO(0, $nombre, $email, $password, $tipo); 
    $userDAO->create($nuevoUsuario);

    $mensaje = "Usuario creado correctamente.";
}
?>

<h2>Crear Usuario</h2>
<?php if ($mensaje): ?>
    <p><?= $mensaje ?></p>
<?php endif; ?>

<form method="post">
    <label>Nombre:</label><input type="text" name="nombre" required><br>
    <label>Email:</label><input type="email" name="email" required><br>
    <label>Contraseña:</label><input type="password" name="password" required><br>
    <label>Tipo:</label>
    <select name="tipo">
        <option value="usuario">Usuario</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <button type="submit">Crear</button>
</form>
