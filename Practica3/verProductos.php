<?php
require_once("includes/config.php");
require_once("includes/verProductos/procesarVerProductos.php");

$tituloPagina = "Ver Productos";

$contenidoProductos = verProductos::mostrarTodos();

$contenidoPrincipal = <<<EOS
<h1>Lista de Productos</h1>
<div class="productos-container">
{$contenidoProductos}
</div>
EOS;

require("includes/comun/plantilla.php");
?>
