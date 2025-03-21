<?php
require_once("includes/config.php"); // Carga config, app, sesión, etc.
require_once("includes/profile/procesarProfile.php");

$tituloPagina = "Mi Perfil";

// Genera el contenido de la vista desde el objeto que extiende formBase
$form = new profileForm();
$contenidoPrincipal = $form->Manage();

require("includes/comun/plantilla.php");
?>
