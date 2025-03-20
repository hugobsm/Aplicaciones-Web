<?php
require_once("includes/config.php");
require_once("includes/accionCompra/procesarCompra.php");

$tituloPagina = "Comprar Producto";
$idProducto = $_GET['id'] ?? null;

if (!$idProducto) {
    die("Producto no encontrado.");
}

$form = new comprarProductoForm($idProducto);
$contenidoPrincipal = <<<EOS
    <h1>Comprar Producto</h1>
    <div class="comprar-container">
        {$form->Manage()}
    </div>
EOS;

require("includes/comun/plantilla.php");
?>
