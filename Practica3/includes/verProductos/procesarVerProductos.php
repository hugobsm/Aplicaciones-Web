<?php

include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../productos/productoAppService.php";

class verProductosForm extends formBase
{
    public function __construct()
    {
        parent::__construct('verProductosForm');
    }

    protected function CreateFields($datos)
    {
        $productoAppService = productoAppService::GetSingleton();
        $productos = $productoAppService->obtenerTodosLosProductos();

        if (!$productos) {
            return "<p>No hay productos disponibles en este momento.</p>";
        }

        $html = "<div class='productos-container'>";
        foreach ($productos as $producto) {
            $idProducto = $producto->getId();
            $html .= <<<EOF
            <div class="product">
                <a href="verProducto.php?id={$idProducto}">
                    <img src="{$producto->getImagen()}" alt="Imagen del producto">
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

    public function mostrarProductos()
    {
        return $this->CreateFields([]);
    }
}
?>
