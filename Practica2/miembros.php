<?php
$tituloPagina = "Nuestro Equipo";
$contenidoPrincipal = <<<EOS

<br><br><br> <!-- Saltos de línea para que la cabecera no se solape -->

<h1 style="text-align: center;">Nuestro Equipo</h1>

<div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">

    <!-- Primera fila con 3 tarjetas -->
    <div style="display: flex; gap: 20px;">
        <div style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); width: 300px;">
            <div style="text-align: center;">
                <img src="Imagenes Miembros/pasis.png" alt="Pablo de Asís" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <h2>Pablo de Asís</h2>
                <p>Email: pasis@ucm.es</p>
            </div>
            <p style="text-align: justify;">Amante del baloncesto y la moda, dos pasatiempos que le apasionan, ya sea jugando o siguiendo las últimas tendencias. También le gusta el fútbol.</p>
        </div>

        <div style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); width: 300px;">
            <div style="text-align: center;">
                <img src="Imagenes Miembros/hugobois.png" alt="Hugo Boisseleau" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <h2>Hugo Boisseleau</h2>
                <p>Email: hugobois@ucm.es</p>
            </div>
            <p style="text-align: justify;">Apasionado de la moda y el diseño, siempre en busca de nuevas tendencias y formas de expresión creativa.</p>
        </div>

        <div style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); width: 300px;">
            <div style="text-align: center;">
                <img src="Imagenes Miembros/victol02.jpg" alt="Victoria Lopez" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <h2>Victoria López</h2>
                <p>Email: victol02@ucm.es</p>
            </div>
            <p style="text-align: justify;">Le gusta la moda, siempre al tanto de las últimas tendencias. También disfruta de la música pop, pero sobre todo del techno y del rock.</p>
        </div>
    </div>

    <!-- Segunda fila con 2 tarjetas centradas -->
    <div style="display: flex; gap: 20px;">
        <div style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); width: 300px;">
            <div style="text-align: center;">
                <img src="Imagenes Miembros/mariom48.jpg" alt="Mario Martín" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <h2>Mario Martín</h2>
                <p>Email: mariom48@ucm.es</p>
            </div>
            <p style="text-align: justify;">Es un apasionado del fútbol, ya sea jugando en el campo o viéndolo por la televisión. También le gusta viajar y conocer nuevas culturas.</p>
        </div>

        <div style="background-color: #f0f0f0; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); width: 300px;">
            <div style="text-align: center;">
                <img src="Imagenes Miembros/oplatero.jpg" alt="Óscar Platero" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <h2>Óscar Platero</h2>
                <p>Email: oplatero@ucm.es</p>
            </div>
            <p style="text-align: justify;">Le gusta jugar al pádel, el tenis y practicar deporte en general. También valora mucho el tiempo con su familia y viajar a destinos únicos.</p>
        </div>
    </div>

</div>

<br><br><br> <!-- Saltos de línea después de las tarjetas -->

EOS;

require("includes/vistas/plantilla/plantilla.php");
