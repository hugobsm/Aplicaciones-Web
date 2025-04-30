<?php
require_once("includes/config.php");
require_once("includes/editarProducto/procesarEditarProducto.php");

$tituloPagina = "Editar Producto";

$formularioEditar = new editarProductoForm();
$contenidoPrincipal = $formularioEditar->Manage();

require("includes/comun/plantilla.php");
?>