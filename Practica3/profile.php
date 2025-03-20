<?php
require_once("includes/config.php");
require_once("includes/profile/procesarProfile.php");

$tituloPagina = "Mi Perfil";

$contenidoPrincipal = <<<EOS
    <div class="perfil-container">
        <h1>Mi Perfil</h1>

        <div class="perfil-info">
            <img class="perfil-foto" src="{$foto_perfil}" alt="Foto de perfil">
            <div class="perfil-datos">
                <p><strong>Nombre:</strong> {$nombre}</p>
                <p><strong>Email:</strong> {$email}</p>
            </div>
        </div>

        <!-- Botón para publicar artículos -->
        <div class="publicar-container">
            <a href="/includes/productos/acciones/publicararticulo.php" class="button publicar-button">Publicar Artículo</a>
        </div>

        <h2>Mis Productos</h2>
        <div class="productos-container">
EOS;

// Si no hay productos, muestra un mensaje
if ($mensaje) {
    $contenidoPrincipal .= "<p class='no-products'>{$mensaje}</p>";
} else {
    // Mostrar productos en tarjetas
    foreach ($productos as $producto) {
        $contenidoPrincipal .= <<<HTML
            <div class="product-card">
                <img class="product-image" src="uploads/{$producto['imagen']}" alt="Imagen del producto">
                <div class="product-details">
                    <h3 class="product-name">{$producto['nombre_producto']}</h3>
                    <p class="product-description">{$producto['descripcion']}</p>
                    <p class="product-price"><strong>Precio:</strong> \${$producto['precio']}</p>
                    <p class="product-date"><strong>Publicado:</strong> {$producto['fecha_publicacion']}</p>
                </div>
                <div class="product-buttons">
                    <a href="editarproducto.php?id={$producto['id_producto']}" class="button edit-button">Editar</a>
                    <a href="eliminarproducto.php?id={$producto['id_producto']}" class="button delete-button">Eliminar</a>
                </div>
            </div>
HTML;
    }
}

$contenidoPrincipal .= "</div></div>";

require("includes/comun/plantilla.php");
?>
