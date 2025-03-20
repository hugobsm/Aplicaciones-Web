<?php
require_once("includes/config.php");
require_once("includes/profile/procesarProfile.php");

$tituloPagina = "Mi Perfil";

$contenidoPrincipal = <<<EOS
    <div class="perfil-container">
        <h1>Mi Perfil</h1>
        <div class="perfil-info">
            <img class="perfil-foto" src="{$foto_perfil}" alt="Foto de perfil">
            <p><strong>Nombre:</strong> {$nombre}</p>
            <p><strong>Email:</strong> {$email}</p>
        </div>

        <h2>Mis Productos</h2>
        <div class="productos-container">
EOS;

if ($mensaje) {
    $contenidoPrincipal .= "<p class='no-products'>{$mensaje}</p>";
} else {
    foreach ($productos as $producto) {
        $contenidoPrincipal .= <<<HTML
            <div class="product">
                <img src="uploads/{$producto['imagen']}" alt="Imagen del producto">
                <div class="product-info">
                    <p class="product-name"><strong>{$producto['nombre_producto']}</strong></p>
                    <p class="product-description">{$producto['descripcion']}</p>
                    <p class="product-price"><strong>Precio:</strong> \${$producto['precio']}</p>
                    <p class="product-date"><strong>Publicado:</strong> {$producto['fecha_publicacion']}</p>
                </div>
                <div class="buttons">
                    <a href="editarproducto.php?id={$producto['id_producto']}" class="button">Editar</a>
                    <a href="eliminarproducto.php?id={$producto['id_producto']}" class="button">Eliminar</a>
                </div>
            </div>
HTML;
    }
}
$contenidoPrincipal .= <<<EOS
    <a href="publicarArticulo.php" class="button">Publicar Nuevo Producto</a>
EOS;

$contenidoPrincipal .= "</div></div>";

require("includes/comun/plantilla.php");
?>
