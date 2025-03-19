<?php

require_once("includes/config.php");

require_once("includes/login/registerForm.php");

$tituloPagina = 'Registro en el sistema';

$form = new registerForm(); 

$htmlFormRegistro = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$htmlFormRegistro
EOS;

require("includes/comun/plantilla.php");
?>