<?php
require_once("config.php"); // Carga la configuración de la BD y la app
require_once("includes/login/registerForm.php");

$tituloPagina = 'Registro de usuario';

$form = new registerForm(); 

$htmlFormRegister = $form->Manage(); // Renderiza el formulario

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$htmlFormRegister
EOS;

require("includes/comun/plantilla.php"); // Usa la plantilla común de la aplicación
?>
