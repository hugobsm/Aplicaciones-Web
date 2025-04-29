<?php
require_once("includes/config.php");
require_once("includes/productos/productoAppService.php");

$tituloPagina = 'Portada';
$app = application::getInstance();
$mensaje = $app->getAtributoPeticion('mensaje');

$productoService = productoAppService::GetSingleton();
$ultimosProductos = $productoService->obtenerProductosPaginados(1); // primera página = productos recientes

$productosHTML = "";
foreach ($ultimosProductos as $producto) {
    $nombre = htmlspecialchars($producto->getNombre());
    $imagen = $producto->getImagen();
    $imgTag = str_starts_with($imagen, 'uploads')
        ? '<img src="' . $imagen . '" alt="' . $nombre . '">' 
        : '<img src="data:image/png;base64,' . $imagen . '" alt="' . $nombre . '">';

    $productosHTML .= <<<HTML
        <div class="producto">
            {$imgTag}
            <p>{$nombre}</p>
        </div>
    HTML;
}

$contenidoPrincipal = <<<EOS
<section class="banner">
    <button class="btn-productos" onclick="location.href='verProductos.php'">Ver Productos</button>
</section>

<section class="productos">
    <h2>Últimas Novedades</h2>
    <div class="carousel">
        {$productosHTML}
    </div>
</section>
EOS;

require("includes/comun/plantilla.php");
