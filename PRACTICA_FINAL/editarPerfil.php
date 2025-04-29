<?php
require_once("includes/config.php");
require_once("includes/editarPerfil/procesarEditarPerfil.php");

$tituloPagina = "Editar Perfil";

$formularioEditar = new editarPerfilForm();
$contenidoPrincipal = $formularioEditar->Manage();

require("includes/comun/plantilla.php");
?>
