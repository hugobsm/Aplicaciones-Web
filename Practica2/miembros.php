<?php
$tituloPagina = 'Miembros';

$contenidoPrincipal = <<<EOS
    <section class="banner" style="
        width: 100%;
        height: 50vh;
        background: url('Imagenes Marca/banner.jpg') no-repeat center center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        color: black;
    ">
        <h1>Team Members</h1>
    </section>
    
    <section class="container" style="width: 80%; margin: 50px auto; text-align: center;">
        <ul class="member-list" style="list-style: none; padding: 0; display: flex; justify-content: center; gap: 15px;">
            <li><a href="#member1" style="text-decoration: none; color: #333; font-weight: bold; padding: 10px 15px; border-radius: 5px; background-color: #ddd; transition: 0.3s;">Pablo de Asís</a></li>
            <li><a href="#member2" style="text-decoration: none; color: #333; font-weight: bold; padding: 10px 15px; border-radius: 5px; background-color: #ddd; transition: 0.3s;">Hugo Boisseleau</a></li>
            <li><a href="#member3" style="text-decoration: none; color: #333; font-weight: bold; padding: 10px 15px; border-radius: 5px; background-color: #ddd; transition: 0.3s;">Victoria Lopez</a></li>
            <li><a href="#member4" style="text-decoration: none; color: #333; font-weight: bold; padding: 10px 15px; border-radius: 5px; background-color: #ddd; transition: 0.3s;">Mario Martín</a></li>
            <li><a href="#member5" style="text-decoration: none; color: #333; font-weight: bold; padding: 10px 15px; border-radius: 5px; background-color: #ddd; transition: 0.3s;">Óscar Platero</a></li>
        </ul>
        
        <div id="member1" class="member" style="margin-top: 40px; padding: 20px;">
            <h2>Pablo de Asís</h2>
            <img src="Imagenes Miembros/pasis.png" alt="Pablo de Asis" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #333;">
            <p>Email: pasis@ucm.es</p>
            <p>Es un amante del baloncesto y de la moda. También le gusta el fútbol y la música.</p>
        </div>
        
        <div id="member2" class="member" style="margin-top: 40px; padding: 20px;">
            <h2>Hugo Boisseleau</h2>
            <img src="Imagenes Miembros/hugobois.png" alt="Hugo Boisseleau" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #333;">
            <p>Email: hugobois@ucm.es</p>
            <p>Es un apasionado de la moda y del diseño. Le gusta dibujar y la fotografía.</p>
        </div>

        <div id="member3" class="member" style="margin-top: 40px; padding: 20px;">
            <h2>Victoria Lopez</h2>
            <img src="Imagenes Miembros/victol02.jpg" alt="Victoria Lopez" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #333;">
            <p>Email: victol02@ucm.es</p>
            <p>Le gusta viajar y descubrir culturas.</p>
        </div>

        <div id="member4" class="member" style="margin-top: 40px; padding: 20px;">
            <h2>Mario Martín</h2>
            <img src="Imagenes Miembros/mariom48.jpg" alt="Mario Martín" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #333;">
            <p>Email: mariom48@ucm.es</p>
            <p>Le gusta hacer deporte y estar con su familia y amigos.</p>
        </div>

        <div id="member5" class="member" style="margin-top: 40px; padding: 20px;">
            <h2>Óscar Platero</h2>
            <img src="Imagenes Miembros/oplatero.jpg" alt="Óscar Platero" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #333;">
            <p>Email: oplatero@ucm.es</p>
            <p>Le gusta el fútbol y el tenis. Le gusta trabajar y viajar.</p>
        </div>
    </section>
EOS;

require("includes/vistas/plantilla/plantilla.php");
