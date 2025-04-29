<?php
include __DIR__ . "/../productos/productoAppService.php";

class verProductos
{
    public static function mostrarTodos()
    {
        $productoAppService = productoAppService::GetSingleton();

        // 🆕 AÑADIR ESTO
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;

        // Si se han pasado filtros por GET, aplicar filtrado
        $categoriasSeleccionadas = $_GET['categorias'] ?? [];
        $precioMaximo = isset($_GET['precio_rango']) ? floatval($_GET['precio_rango']) : null;

        $productosPorPagina = 10;

        if (!empty($categoriasSeleccionadas)) {
            $productos = $productoAppService->obtenerProductosPorCategorias($categoriasSeleccionadas);
        } else {
            $productos = $productoAppService->obtenerTodosLosProductos();
        }

        if ($precioMaximo !== null) {
            $productos = array_filter($productos, function($producto) use ($precioMaximo) {
                return $producto->getPrecio() <= $precioMaximo;
            });
        }

        if (!$productos || empty($productos)) {
            return "<p>No hay productos disponibles en este momento.</p>";
        }


        // Paginación manual
        $totalProductos = count($productos);
        $totalPaginas = ceil($totalProductos / $productosPorPagina);

        // Sacar los productos de esta página
        $inicio = ($pagina - 1) * $productosPorPagina;
        $productosPagina = array_slice($productos, $inicio, $productosPorPagina);



        $html = "<div class='productos-container'>";
        /*foreach ($productos as $producto) {
            $idProducto = $producto->getId();
            $nombre = htmlspecialchars($producto->getNombre());
            $descripcion = htmlspecialchars($producto->getDescripcion());
            $precio = number_format($producto->getPrecio(), 2);
            $fecha = htmlspecialchars($producto->getFechaPublicacion());
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
        }*/
        foreach ($productosPagina as $producto) {
            $idProducto = $producto->getId();
            $nombre = htmlspecialchars($producto->getNombre());
            $descripcion = htmlspecialchars($producto->getDescripcion());
            $precio = number_format($producto->getPrecio(), 2);
            $fecha = htmlspecialchars($producto->getFechaPublicacion());
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


        // Botones de paginación numerados
    // Construir paginación con filtros mantenidos
    $queryParams = $_GET;
    unset($queryParams['pagina']); // Quitamos pagina para no duplicar
    $queryBase = http_build_query($queryParams);

    if ($totalPaginas > 1) {
        $html .= "<div class='paginacion'>";
        for ($i = 1; $i <= $totalPaginas; $i++) {
            $active = ($i == $pagina) ? "active" : "";
            $url = '?' . $queryBase . '&pagina=' . $i;
            $html .= "<a class='pagina-numero {$active}' href='{$url}'>" . $i . "</a> ";
        }
        $html .= "</div>";
    }



        return $html;
    }
}

?>
