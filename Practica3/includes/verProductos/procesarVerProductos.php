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
            $html .= <<<EOF
            <div class="product">
                <img src="{$producto->getImagen()}" alt="Imagen del producto">
                <div class="product-info">
                    <p class="product-name"><strong>{$producto->getNombre()}</strong></p>
                    <p class="product-description">{$producto->getDescripcion()}</p>
                    <p class="product-price"><strong>Precio:</strong> \${$producto->getPrecio()}</p>
                    <p class="product-date"><strong>Publicado:</strong> {$producto->getFechaPublicacion()}</p>
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
