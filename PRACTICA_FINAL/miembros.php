<?php
require_once("includes/config.php");
$tituloPagina = "Nuestro Equipo";
$app = application::getInstance();

$mensaje = $app->getAtributoPeticion('mensaje');
$contenidoPrincipal = <<<EOS

<h1 class="titulo-equipo">Nuestro Equipo</h1>

<div class="equipo-container">

    <!-- Fila de tarjetas -->
    <div class="equipo-fila">
        <!-- Tarjeta 1 -->
        <div class="equipo-tarjeta">
            <div class="tarjeta-contenido">
                <img src="Imagenes Miembros/pasis.png" alt="Pablo de Asís" class="imagen-miembro">
                <h2>Pablo de Asís</h2>
                <p>Email: pasis@ucm.es</p>
            </div>
            <p>Amante del baloncesto y la moda, dos pasatiempos que le apasionan, ya sea jugando o siguiendo las últimas tendencias. También le gusta el fútbol.</p>
        </div>

        <!-- Tarjeta 2 -->
        <div class="equipo-tarjeta">
            <div class="tarjeta-contenido">
                <img src="Imagenes Miembros/hugobois.png" alt="Hugo Boisseleau" class="imagen-miembro">
                <h2>Hugo Boisseleau</h2>
                <p>Email: hugobois@ucm.es</p>
            </div>
            <p>Apasionado de la moda y el diseño, siempre en busca de nuevas tendencias y formas de expresión creativa.</p>
        </div>

        <!-- Tarjeta 3 -->
        <div class="equipo-tarjeta">
            <div class="tarjeta-contenido">
                <img src="Imagenes Miembros/victol02.jpg" alt="Victoria Lopez" class="imagen-miembro">
                <h2>Victoria López</h2>
                <p>Email: victol02@ucm.es</p>
            </div>
            <p>Le gusta la moda, siempre al tanto de las últimas tendencias. También disfruta de la música pop, pero sobre todo del techno y del rock.</p>
        </div>
    </div>

    <!-- Fila de tarjetas centradas -->
    <div class="equipo-fila">
        <!-- Tarjeta 4 -->
        <div class="equipo-tarjeta">
            <div class="tarjeta-contenido">
                <img src="Imagenes Miembros/mariom48.jpg" alt="Mario Martín" class="imagen-miembro">
                <h2>Mario Martín</h2>
                <p>Email: mariom48@ucm.es</p>
            </div>
            <p>Es un apasionado del fútbol, ya sea jugando en el campo o viéndolo por la televisión. También le gusta viajar y conocer nuevas culturas.</p>
        </div>

        <!-- Tarjeta 5 -->
        <div class="equipo-tarjeta">
            <div class="tarjeta-contenido">
                <img src="Imagenes Miembros/oplatero.jpg" alt="Óscar Platero" class="imagen-miembro">
                <h2>Óscar Platero</h2>
                <p>Email: oplatero@ucm.es</p>
            </div>
            <p>Le gusta jugar al pádel, el tenis y practicar deporte en general. También valora mucho el tiempo con su familia y viajar a destinos únicos.</p>
        </div>
    </div>

</div>

<br><br><br> <!-- Saltos de línea después de las tarjetas -->

EOS;

require("includes/comun/plantilla.php");
