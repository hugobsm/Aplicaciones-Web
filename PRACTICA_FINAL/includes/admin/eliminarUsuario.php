<?php
require_once __DIR__ . '/../usuario/userDAO.php';

// Comprobar si el usuario está autenticado y tiene el rol adecuado
if ($_SESSION['tipo'] !== 'admin') {
    // Si no es admin o no está autenticado, redirigir a la página de inicio
    header("Location: /Aplicaciones-Web/PRACTICA_FINAL/index.php");
    exit();

}

/*if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}*/

if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);
    $userDAO = new userDAO();
    $userDAO->delete($idUsuario);
}

header("Location: verUsuario.php");
exit();
