<?php
include __DIR__ . "/../productos/productoAppService.php";

class verProductosForm
{
    public function mostrarProductos()
    {
        $productoAppService = productoAppService::GetSingleton();
        $productos = $productoAppService->obtenerTodosLosProductos();

        if (!$productos) {
            return "<p>No hay productos disponibles en este momento.</p>";
        }

        $html = "<div class='productos-container'>";
        foreach ($productos as $producto) {
            $idProducto = $producto->getId();
            $imgSrc = str_starts_with($producto->getImagen(), 'uploads')
                ? $producto->getImagen()
                : 'data:image/png;base64,' . $producto->getImagen();

            $html .= <<<EOF
            <div class="product">
                <a href="verProducto.php?id={$idProducto}">
                    <img src="$imgSrc" alt="Imagen del producto">
                </a>
                <div class="product-info">
                    <p class="product-name"><strong>{$producto->getNombre()}</strong></p>
                    <p class="product-description">{$producto->getDescripcion()}</p>
                    <p class="product-price"><strong>Precio:</strong> \${$producto->getPrecio()}</p>
                    <p class="product-date"><strong>Publicado:</strong> {$producto->getFechaPublicacion()}</p>
                    <a href="verProducto.php?id={$idProducto}" class="ver-detalle">Ver más</a>
                </div>
            </div>
EOF;
        }
        $html .= "</div>";

        return $html;
    }
}
?>
