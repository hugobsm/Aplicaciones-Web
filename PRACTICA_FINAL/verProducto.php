<?php
require_once("includes/config.php");
require_once("includes/verProductos/procesarVerProducto.php");

$tituloPagina = "Detalle del Producto";

$idProducto = $_GET['id'] ?? null;

if (!$idProducto) {
    die("Producto no encontrado.");
}

$producto = procesarVerProducto::obtenerProducto($idProducto);

if (!$producto) {
    die("No se pudo cargar el producto.");
}

$contenidoPrincipal = <<<EOS
    <div class="producto-detalle">
        <h1>{$producto->getNombre()}</h1>
        <img src="{$producto->getImagen()}" alt="Imagen del producto">
        <p class="descripcion">{$producto->getDescripcion()}</p>
        <p class="precio"><strong>Precio:</strong> \${$producto->getPrecio()}</p>
        <p class="fecha"><strong>Publicado el:</strong> {$producto->getFechaPublicacion()}</p>
        
        <a href="comprarProducto.php?id={$producto->getId()}" class="button">Comprar</a>
    </div>
EOS;
// Añadir valoraciones después del producto
$valoraciones = procesarVerProducto::obtenerValoracionesDeVendedor($idProducto);
$valoracionesHtml = "<div class='valoraciones'><h3>Valoraciones del vendedor</h3>";

if (empty($valoraciones)) {
    $valoracionesHtml .= "<p>No hay valoraciones disponibles.</p>";
} else {
    foreach ($valoraciones as $val) {
        $comentario = htmlspecialchars($val->getComentario());
        $puntuacion = intval($val->getPuntuacion());
        $valoracionesHtml .= "<div class='valoracion'>
            <strong>Puntuación:</strong> {$puntuacion} / 5<br>
            <strong>Comentario:</strong> {$comentario}
        </div>";
    }
}
$valoracionesHtml .= "</div>";

$contenidoPrincipal .= $valoracionesHtml;

require("includes/comun/plantilla.php");
