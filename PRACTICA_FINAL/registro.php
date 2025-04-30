<?php
require_once("includes/config.php"); // Carga la configuración de la BD y la app
require_once("includes/login/registerForm.php");

$tituloPagina = 'Registro de usuario';

$form = new registerForm(); 

$htmlFormRegister = $form->Manage(); // Renderiza el formulario

$contenidoPrincipal = <<<EOS

$htmlFormRegister
EOS;

require("includes/comun/plantilla.php"); // Usa la plantilla común de la aplicación
?>
