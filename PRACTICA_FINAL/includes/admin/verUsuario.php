<?php
require_once __DIR__ . '/../usuario/userDAO.php';
require_once __DIR__ . '/../comun/cabecera.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Solo el admin puede ver esto
if (!isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

$userDAO = new userDAO();
$usuarios = $userDAO->findAll(); // Método que recupera todos los usuarios
?>

<h2>Lista de Usuarios</h2>
<a href="crearUsuario.php">Crear nuevo usuario</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario->id() ?></td>
            <td><?= $usuario->nombre() ?></td>
            <td><?= $usuario->email() ?></td>
            <td><?= $usuario->tipo() ?></td>
            <td>
                <a href="eliminarUsuario.php?id=<?= $usuario->id() ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
