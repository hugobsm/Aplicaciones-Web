<?php
session_start();
require_once(__DIR__ . '/../usuario/userAppService.php');

$status = $_GET['status'] ?? 'ko';
$importe = $_SESSION['importe_recarga'] ?? 0;
$id_usuario = $_SESSION['id_usuario'] ?? null;

if ($status !== 'ok') {
    echo "<h2>❌ El pago fue cancelado o fallido</h2>";
    exit();
}

if (!$id_usuario || $importe <= 0) {
    echo "<h2>❌ No se pudo procesar la recarga.</h2>";
    exit();
}

// Obtener instancia del servicio de usuario
$userService = userAppService::GetSingleton();
$usuario = $userService->getUserById($id_usuario);

if (!$usuario) {
    echo "<h2>❌ Usuario no encontrado.</h2>";
    exit();
}

// Sumar el saldo
$ok = $userService->sumarSaldo($id_usuario, $importe);

if ($ok) {
    $nuevoSaldo = $usuario->saldo() + $importe;
    echo "<h2>✅ Recarga completada con éxito</h2>";
    echo "<p>Se han añadido <strong>{$importe}€</strong> a tu cuenta.</p>";
    echo "<p>Tu nuevo saldo es: <strong>{$nuevoSaldo}€</strong></p>";
    unset($_SESSION['importe_recarga']);
    echo "<div style='margin-top: 20px;'>
        <a href='/Aplicaciones-Web/PRACTICA_FINAL/profile.php' style='
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        '>Volver al perfil</a>
      </div>";

} else {
    echo "<h2>❌ Error al actualizar el saldo en la base de datos.</h2>";
    echo "<div style='margin-top: 20px;'>
        <a href='/Aplicaciones-Web/PRACTICA_FINAL/profile.php' style='
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        '>Volver al perfil</a>
      </div>";

}
?>
