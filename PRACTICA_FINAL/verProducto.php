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

$valoraciones = procesarVerProducto::obtenerValoracionesDeVendedor($idProducto);
$mediaPuntuacion = procesarVerProducto::obtenerMediaValoracionVendedor($producto->getIdUsuario());

// ⭐ Generar estrellas
$estrellas = "";
$mediaRedondeada = round($mediaPuntuacion);
for ($i = 1; $i <= 5; $i++) {
    $estrellas .= ($i <= $mediaRedondeada) ? "★" : "☆";
}

// 📝 Valoraciones HTML
$valoracionesHtml = "<div class='valoraciones-box'>
    <h3>Valoraciones del vendedor</h3>
    <div class='media-valoracion'>
        <span class='estrellas'>$estrellas</span>
        <span class='nota-media'>(" . number_format($mediaPuntuacion, 1) . " / 5)</span>
    </div>
    <div class='valoraciones-scroll'>";

if (empty($valoraciones)) {
    $valoracionesHtml .= "<p>No hay valoraciones disponibles.</p>";
} else {
    foreach ($valoraciones as $val) {
        $comentario = htmlspecialchars($val->getComentario());
        $puntuacion = intval($val->getPuntuacion());
        $fecha = htmlspecialchars($val->getFechaValoracion());
        $emailComprador = htmlspecialchars($val->emailComprador ?? "");

        $valoracionesHtml .= "<div class='valoracion'>
            <strong>Email del comprador:</strong> {$emailComprador}<br>
            <strong>Puntuación:</strong> {$puntuacion} / 5<br>
            <strong>Comentario:</strong> {$comentario}<br>
            <strong>Fecha de valoración:</strong> {$fecha}
        </div>";
    }
}

$valoracionesHtml .= "</div></div>";

// ✅ HTML final unificado
$contenidoPrincipal = <<<EOS
<div class="detalle-wrapper">
    <div class="producto-detalle">
        <h1>{$producto->getNombre()}</h1>
        <img src="{$producto->getImagen()}" alt="Imagen del producto">
        <p class="descripcion">{$producto->getDescripcion()}</p>
        <p class="precio"><strong>Precio:</strong> \${$producto->getPrecio()}</p>
        <p class="fecha"><strong>Publicado el:</strong> {$producto->getFechaPublicacion()}</p>
        <a href="comprarProducto.php?id={$producto->getId()}" class="button">Comprar</a>
    </div>
    $valoracionesHtml
</div>
EOS;

require("includes/comun/plantilla.php");
?>
