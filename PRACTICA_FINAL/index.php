<?php
require_once("includes/config.php");
require_once("includes/productos/productoAppService.php");

$tituloPagina = 'Portada';
$app = application::getInstance();
$mensaje = $app->getAtributoPeticion('mensaje');

$productoService = productoAppService::GetSingleton();
$ultimosProductos = $productoService->obtenerProductosPaginados(1); // primera página = productos recientes

$productosHTML = "";
$contador = 0;

foreach ($ultimosProductos as $producto) {
    if ($contador >= 5) break; // Limitar a 5 productos

    $nombre = htmlspecialchars($producto->getNombre());
    $imagen = htmlspecialchars($producto->getImagen());
    $precio = htmlspecialchars($producto->getPrecio());

    // Etiqueta de la imagen con verificación de formato
    $imgTag = str_starts_with($imagen, 'uploads/')
        ? '<img src="' . $imagen . '" alt="' . $nombre . '" class="producto-imagen">'
        : '<img src="data:image/png;base64,' . $imagen . '" alt="' . $nombre . '" class="producto-imagen">';

    // Botón dinámico según login
    $botonComprar = (isset($_SESSION['login']) && $_SESSION['login'] === true)
        ? '<a href="comprarProducto.php?id=' . htmlspecialchars($producto->getId()) . '" class="button producto-boton">Comprar ' . $precio . '€</a>'
        : '<a href="login.php" class="button producto-boton">Inicia sesión para comprar</a>';

    $productosHTML .= <<<HTML
    <div class="producto-item">
        $imgTag
        <p class="producto-nombre">{$nombre}</p>
        {$botonComprar}
    </div>
    HTML;

    $contador++;
}

$contenidoPrincipal = <<<EOS
<section class="banner">
    <button class="btn-productos" onclick="location.href='verProductos.php'">Ver Productos</button>
</section>

<section class="productos">
    <h2>Últimas Novedades</h2>
    <div class="carousel slick-carousel">
        {$productosHTML}
    </div>
</section>

<!-- Incluir Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<!-- Inicialización de Slick -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    // Inicializa el carrusel Slick
    $('.slick-carousel').slick({
        slidesToShow: 3,   // Número de productos visibles a la vez
        slidesToScroll: 1, // Número de productos que se desplazan al hacer clic
        autoplay: true,    // Hace que el carrusel avance automáticamente
        autoplaySpeed: 2000, // Velocidad del desplazamiento automático (en ms)
        arrows: true,      // Habilitar flechas
        dots: true,        // Habilitar puntos de navegación
        responsive: [
            {
                breakpoint: 768,  // Para pantallas más pequeñas
                settings: {
                    slidesToShow: 2,  // Mostrar 2 productos en pantallas más pequeñas
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 480,  // Para pantallas muy pequeñas (como móviles)
                settings: {
                    slidesToShow: 1,  // Mostrar 1 producto en pantallas muy pequeñas
                    slidesToScroll: 1,
                }
            }
        ]
    });
});
</script>
EOS;

require("includes/comun/plantilla.php");
?>
