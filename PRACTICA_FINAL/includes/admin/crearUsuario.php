<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . "/../login/registerForm.php");

// Comprobar si el usuario está autenticado y tiene el rol adecuado
if ($_SESSION['tipo'] !== 'admin') {
    // Si no es admin o no está autenticado, redirigir a la página de inicio
    header("Location: /Aplicaciones-Web/PRACTICA_FINAL/index.php");
    exit();    
}
$tituloPagina = 'Registro de usuario';

$form = new registerForm(); 

$htmlFormRegister = $form->Manage(); // Renderiza el formulario

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$htmlFormRegister
EOS;

require(__DIR__ . "/../comun/plantilla.php"); // Usa la plantilla común de la aplicación
?>


