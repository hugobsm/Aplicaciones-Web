<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . "/../login/registerForm.php");

$tituloPagina = 'Registro de usuario';

$form = new registerForm(); 

$htmlFormRegister = $form->Manage(); // Renderiza el formulario

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$htmlFormRegister
EOS;

require(__DIR__ . "/../comun/plantilla.php"); // Usa la plantilla común de la aplicación
?>


