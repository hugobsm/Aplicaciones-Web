<?php

require_once("includes/config.php");

$tituloPagina = 'Portada';

$app = application::getInstance();

$mensaje = $app->getAtributoPeticion('mensaje');
		
$contenidoPrincipal = <<<EOS
    <section class="banner">
    <button class="btn-productos" onclick="location.href='productos.php'">Ver Productos</button>
</section>

<section class="productos">
    <h2>Últimas Novedades</h2>
    <div class="carousel">
        <div class="producto">
            <img src="Imagenes Marca/camiseta.jpeg" alt="Producto 1">
            <p>Camiseta Red Bull</p>
        </div>
        <div class="producto">
            <img src="Imagenes Marca/sudadera.jpeg" alt="Producto 2">
            <p>Sudadera Champion</p>
        </div>
        <div class="producto">
            <img src="Imagenes Marca/pantalon.jpeg" alt="Producto 3">
            <p>Pantalón H&M</p>
        </div>
    </div>
</section>
EOS;

require("includes/comun/plantilla.php");
?>