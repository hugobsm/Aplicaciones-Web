<?php
include __DIR__ . "/../productos/productoAppService.php";

class verProductos
{
    public static function mostrarTodos()
    {
        $productoAppService = productoAppService::GetSingleton();
        $productos = $productoAppService->obtenerTodosLosProductos();

        if (!$productos || empty($productos)) {
            return "<p>No hay productos disponibles en este momento.</p>";
        }

        $html = "<div class='productos-container'>";
        foreach ($productos as $producto) {
            $idProducto = $producto->getId();
            $nombre = htmlspecialchars($producto->getNombre());
            $descripcion = htmlspecialchars($producto->getDescripcion());
            $precio = number_format($producto->getPrecio(), 2);
            $fecha = htmlspecialchars($producto->getFechaPublicacion());

            // 🖼️ Sin modificar la ruta de la imagen
            $imagen = htmlspecialchars($producto->getImagen());

            $html .= <<<HTML
            <div class="product-card">
                <a href="verProducto.php?id={$idProducto}">
                    <img class="product-image" src="{$fecha}" alt="Imagen del producto">
                </a>
                <div class="product-info">
                    <p class="product-name"><strong>{$nombre}</strong></p>
                    <p class="product-description">{$descripcion}</p>
                    <p class="product-price"><strong>Precio:</strong> \${$precio}</p>
                    <p class="product-date"><strong>Publicado:</strong> {$imagen}</p>
                    <a href="verProducto.php?id={$idProducto}" class="ver-detalle">Ver más</a>
                </div>
            </div>
HTML;
        }

        $html .= "</div>";
        return $html;
    }
}
?>
