<?php
require_once("includes/config.php"); // Carga la configuración de la BD y la app
require_once("includes/login/procesarLogin.php");

$tituloPagina = 'Acceso al sistema';

$form = new loginForm(); 

$htmlFormLogin = $form->Manage(); // Renderiza el formulario

$contenidoPrincipal = <<<EOS
<h1>Login de usuario</h1>
$htmlFormLogin
EOS;

require("includes/comun/plantilla.php"); // Usa la plantilla común de la aplicación
?>
