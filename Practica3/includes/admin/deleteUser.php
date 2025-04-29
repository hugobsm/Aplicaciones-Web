<?php
require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../usuario/userAppService.php");

$tituloPagina = 'Eliminar Usuario';
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["email"])) {
    try {
        $email = trim($_POST["email"]);

        // Obtener el servicio de usuario (que internamente maneja la conexión)
        $userAppService = userAppService::GetSingleton();

        // Ejecutar el borrado
        $eliminado = $userAppService->deleteByEmail($email);

        if ($eliminado) {
            $success = "✅ Usuario eliminado correctamente.";
        } else {
            $error = "❌ No se encontró un usuario con ese email.";
        }

    } catch (Exception $e) {
        $error = "❌ Error al eliminar usuario: " . $e->getMessage();
    }
}

$contenidoPrincipal = <<<HTML
<h1>Eliminar Usuario</h1>
<form method="post">
    <label>Email del usuario a eliminar:</label>
    <input type="email" name="email" required>
    <button type="submit">Eliminar</button>
</form>
HTML;

if (!empty($success)) {
    $contenidoPrincipal .= "<p style='color: green;'>$success</p>";
}
if (!empty($error)) {
    $contenidoPrincipal .= "<p style='color: red;'>$error</p>";
}

require(__DIR__ . "/../comun/plantilla.php");
?>
