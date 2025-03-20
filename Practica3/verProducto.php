<?php
require_once("includes/config.php");
require_once("includes/productos/productoAppService.php");

$tituloPagina = "Detalle del Producto";

$idProducto = $_GET['id'] ?? null;

if (!$idProducto) {
    die("Producto no encontrado.");
}

$productoAppService = productoAppService::GetSingleton();
$producto = $productoAppService->obtenerProductoPorId($idProducto);

if (!$producto) {
    die("El producto solicitado no existe.");
}

$contenidoPrincipal = <<<EOS
    <div class="producto-detalle">
        <h1>{$producto->getNombre()}</h1>
        <img src="{$producto->getImagen()}" alt="Imagen del producto">
        <p class="descripcion">{$producto->getDescripcion()}</p>
        <p class="precio"><strong>Precio:</strong> \${$producto->getPrecio()}</p>
        <p class="fecha"><strong>Publicado el:</strong> {$producto->getFechaPublicacion()}</p>
        <button class="boton-comprar">Comprar</button>
    </div>
EOS;

require("includes/comun/plantilla.php");
?>
