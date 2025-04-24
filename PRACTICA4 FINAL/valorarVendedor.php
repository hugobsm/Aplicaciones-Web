<?php
require_once("includes/config.php"); 
require_once("includes/accionValorarVendedor/procesarValorarVendedor.php");

$tituloPagina = "Valorar Vendedor";

// Puedes pasar el ID por GET, pero que el formulario se encargue de validar y recuperar si hace falta
$form = new valorarVendedorForm($_GET['id_vendedor'] ?? null);

$contenidoPrincipal = $form->Manage();

require("includes/comun/plantilla.php");
?>
