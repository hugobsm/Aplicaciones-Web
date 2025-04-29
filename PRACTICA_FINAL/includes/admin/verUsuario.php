<?php
require_once __DIR__ . '/../usuario/userDAO.php';

// Comprobar si el usuario está autenticado y tiene el rol adecuado
if ($_SESSION['tipo'] !== 'admin') {
    // Si no es admin o no está autenticado, redirigir a la página de inicio
    header("Location: /Aplicaciones-Web/PRACTICA_FINAL/index.php");
    exit();

}

$tituloPagina = 'Lista de usuarios';

/*if (session_status() === PHP_SESSION_NONE) session_start();

// Solo el admin puede ver esto
if (!isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}*/

$userDAO = new userDAO();
$usuarios = $userDAO->findAll(); // Método que recupera todos los usuarios

// Empieza a capturar la salida
ob_start();
?>

<!-- Contenedor principal de la página -->
<div class="lista-usuarios-container">
    <h2>Lista de Usuarios</h2>
    
    <!-- Enlace para crear un nuevo usuario -->
    <a href="crearUsuario.php">Crear nuevo usuario</a>

    <!-- Tabla que muestra la lista de usuarios -->
    <table>
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
</div>

<?php
// Guardar en variable
$contenidoPrincipal = ob_get_clean();
require(__DIR__ . "/../comun/plantilla.php");
?>
