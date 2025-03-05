<?php
$tituloPagina = 'Portada';

$contenidoPrincipal = <<<EOS
    <section class="banner" style="
        width: 100%;
        height: 100vh;
        background: url('Imagenes Marca/banner.jpg') no-repeat center center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        color: black;
    ">
        <button style="
            background-color: black;
            color: white;
            padding: 15px 30px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 20px;
        " onclick="location.href='productos.php'">Ver Productos</button>
    </section>
    
    <section class="productos" style="text-align: center; margin: 50px 0;">
        <h2>Últimas Novedades</h2>
        <div class="carousel" style="display: flex; overflow-x: auto; gap: 20px; padding: 20px;">
            <div style="min-width: 200px; background: #f5f5f5; padding: 20px; border-radius: 10px;">
                <img src="Imagenes Marca/camiseta.jpeg" alt="Producto 1" style="width: 100%;">
                <p>Camiseta Red Bull</p>
            </div>
            <div style="min-width: 200px; background: #f5f5f5; padding: 20px; border-radius: 10px;">
                <img src="Imagenes Marca/sudadera.jpeg" alt="Producto 2" style="width: 100%;">
                <p>Sudadera Champion</p>
            </div>
            <div style="min-width: 200px; background: #f5f5f5; padding: 20px; border-radius: 10px;">
                <img src="Imagenes Marca/pantalon.jpeg" alt="Producto 3" style="width: 100%;">
                <p>Pantalon H&M</p>
            </div>
        </div>
    </section>
EOS;

require("includes/vistas/plantilla/plantilla.php");
