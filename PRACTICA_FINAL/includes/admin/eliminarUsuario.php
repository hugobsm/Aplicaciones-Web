<?php
require_once __DIR__ . '/../usuario/userDAO.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);
    $userDAO = new userDAO();
    $userDAO->delete($idUsuario);
}

header("Location: verUsuario.php");
exit();
