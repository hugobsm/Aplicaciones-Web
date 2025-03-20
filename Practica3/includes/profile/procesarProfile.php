<?php
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../usuario/userAppService.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$userAppService = userAppService::GetSingleton();
$id_usuario = $_SESSION['id_usuario'];

// Obtener datos del usuario
$user = $userAppService->getUserProfile($id_usuario);
if (!$user) {
    die("Error: No se pudo obtener la información del usuario.");
}

// Obtener productos del usuario
$productos = $userAppService->getUserProducts($id_usuario);
$mensaje = empty($productos) ? "No has subido ningún producto aún." : "";

// Datos del usuario para la vista
$nombre = htmlspecialchars($user->nombre(), ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user->email(), ENT_QUOTES, 'UTF-8');

// Verificar y asignar la ruta correcta de la foto de perfil
$foto_perfil = !empty($user->fotoPerfil()) ? htmlspecialchars($user->fotoPerfil(), ENT_QUOTES, 'UTF-8') : "uploads/default-avatar.png";
?>
