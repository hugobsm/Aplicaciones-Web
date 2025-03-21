<?php
require_once("includes/config.php"); 
require_once("includes/accionValorarVendedor/procesarValorarVendedor.php");

$tituloPagina = "Valorar Vendedor";

$id_vendedor = $_GET['id_vendedor'] ?? null;

if (!$id_vendedor) {
    $contenidoPrincipal = "<p>Error: No se especificó un vendedor.</p>";
} else {
    $form = new valorarVendedorForm($id_vendedor);
    $contenidoPrincipal = $form->Manage();
}

require("includes/comun/plantilla.php");
?>
