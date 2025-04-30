
<?php 
require_once("includes/config.php");
require_once("includes/eliminarProducto/procesarEliminarProducto.php");

$tituloPagina = "Eliminar Producto";

$formularioEliminar = new eliminarProductoForm();
$contenidoPrincipal = $formularioEliminar->Manage();

require("includes/comun/plantilla.php");
?> 