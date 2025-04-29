<?php
require_once("includes/config.php"); // Carga la configuración de la BD y la app
require_once("includes/accionCompra/procesarCompra.php");

$tituloPagina = "Comprar Producto";

$form = new comprarProductoForm($_GET['id'] ?? null); // Instancia el formulario con el ID del producto

$htmlFormCompra = $form->Manage(); // Renderiza el formulario

$contenidoPrincipal = <<<EOS
<h1>Comprar Producto</h1>
$htmlFormCompra
EOS;

require("includes/comun/plantilla.php"); // Usa la plantilla común de la aplicación
?>
