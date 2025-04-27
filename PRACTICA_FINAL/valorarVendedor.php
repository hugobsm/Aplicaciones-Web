<?php
require_once("includes/config.php"); 
require_once("includes/accionValorarVendedor/procesarValorarVendedor.php");

$tituloPagina = "Valorar Vendedor";


$id_vendedor = $_GET['id_vendedor'] ?? null;
$id_producto = $_GET['id_producto'] ?? null;

if (!$id_vendedor || !$id_producto) {
    die("Error: Faltan datos para valorar correctamente.");
}


$form = new valorarVendedorForm($id_vendedor, $id_producto);

$contenidoPrincipal = $form->Manage();

require("includes/comun/plantilla.php");
?>
