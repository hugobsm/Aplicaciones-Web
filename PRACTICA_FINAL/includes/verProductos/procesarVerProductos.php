<?php
include __DIR__ . "/../productos/productoAppService.php";


class verProductos
{
    public static function mostrarTodos()
    {
        $productoAppService = productoAppService::GetSingleton();

        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($pagina < 1) $pagina = 1;

        $categoriasSeleccionadas = $_GET['categorias'] ?? [];
        $precioMaximo = isset($_GET['precio_rango']) ? floatval($_GET['precio_rango']) : null;
        $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : ''; // 🆕 Búsqueda

        $productosPorPagina = 12;

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

        // FILTRO DE BÚSQUEDA
        if (!empty($busqueda)) {
            $productos = array_filter($productos, function($producto) use ($busqueda) {
                return stripos($producto->getNombre(), $busqueda) !== false || 
                stripos($producto->getDescripcion(), $busqueda) !== false;
            });
        }

        if (!$productos || empty($productos)) {
            return "<p>No hay productos disponibles en este momento.</p>";
        }

        $totalProductos = count($productos);
        $totalPaginas = ceil($totalProductos / $productosPorPagina);

        $inicio = ($pagina - 1) * $productosPorPagina;
        $productosPagina = array_slice($productos, $inicio, $productosPorPagina);

        $html = "<div class='productos-container'>";
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
                    <img class="product-image" src="{$imagen}" alt="Imagen del producto">
                </a>
                <div class="product-info">
                    <p class="product-name"><strong>{$nombre}</strong></p>
                    <p class="product-description">{$descripcion}</p>
                    <p class="product-price"><strong>Precio:</strong> \${$precio}</p>
                    <p class="product-date"><strong>Publicado:</strong> {$fecha}</p>
                </div>
                <div class="ver-mas-container">
                    <a href="verProducto.php?id={$idProducto}" class="ver-mas-button">Ver más</a>
                </div>
            </div>
HTML;
        }
        $html .= "</div>";

        // PAGINACIÓN
        $queryParams = $_GET;
        unset($queryParams['pagina']);
        $queryBase = http_build_query($queryParams);

        $html .= "<div class='paginacion'>";

        if ($pagina > 1) {
            $prevPage = $pagina - 1;
            $html .= "<a class='pagina-numero prev' href='?$queryBase&pagina=$prevPage'>Anterior</a> ";
        }

        for ($i = 1; $i <= $totalPaginas; $i++) {
            $active = ($i == $pagina) ? "active" : "";
            $url = '?' . $queryBase . '&pagina=' . $i;
            $html .= "<a class='pagina-numero {$active}' href='{$url}'>" . $i . "</a> ";
        }

        if ($pagina < $totalPaginas) {
            $nextPage = $pagina + 1;
            $html .= "<a class='pagina-numero next' href='?$queryBase&pagina=$nextPage'>Siguiente</a>";
        }

        $html .= "</div>";

        return $html;
    }
}

?>
