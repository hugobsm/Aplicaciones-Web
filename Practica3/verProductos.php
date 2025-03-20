<?php
require_once("includes/config.php");
require_once("includes/verProductos/procesarVerProductos.php");

$tituloPagina = "Ver Productos";
$form = new verProductosForm(); // Asegurar que se instancia el formulario
$contenidoPrincipal = <<<EOS
    <h1>Lista de Productos</h1>
    <div class="productos-container">
        {$form->gestiona()}
    </div>
EOS;

require("includes/comun/plantilla.php");
?>
