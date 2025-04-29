<?php
require_once("includes/config.php");

$tituloPagina = "Compra Confirmada";

$contenidoPrincipal = <<<EOS
    <h1>¡Gracias por tu compra!</h1>
    <p>Tu compra se ha realizado con éxito.</p>
    <a href="index.php">Volver a la tienda</a>
EOS;

require("includes/comun/plantilla.php");
?>
