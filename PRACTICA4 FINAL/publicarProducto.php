<?php
require_once("includes/config.php"); 
require_once("includes/productos/acciones/procesarPublicarArticulo.php");

$tituloPagina = "Publicar Producto";

$form = new publicarProductoForm(); 

$htmlFormPublicar = $form->Manage(); 

$contenidoPrincipal = <<<EOS
<h1>Publicar Nuevo Producto</h1>
$htmlFormPublicar
EOS;

require("includes/comun/plantilla.php");
?>
