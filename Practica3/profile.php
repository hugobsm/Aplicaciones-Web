<?php
require_once("includes/config.php"); // Carga config, app, sesión, etc.
require_once("includes/profile/procesarProfile.php");


$form = new profileForm();
$tituloPagina = "Mi perfil";
$contenidoPrincipal = $form->Manage();


require("includes/comun/plantilla.php");
?>
