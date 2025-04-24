<?php
require_once("includes/config.php");
$tituloPagina = "Contacto";
$app = application::getInstance();

$mensaje = $app->getAtributoPeticion('mensaje');
$contenidoPrincipal = <<<EOS
<h1 class="titulo-contacto">Contacto</h1>

<div class="contacto-container">
    <div class="informacion-contacto">
        <h2>Información de Contacto</h2>
        <p><strong>Email:</strong> contacto@brandswap.com</p>
        <p><strong>Teléfono:</strong> +34 912 345 678</p>
        <p><strong>Dirección:</strong> Calle Ejemplo 123, Madrid, España</p>
    </div>

    <div class="formulario-contacto">
        <h2>Envíanos un mensaje</h2>
        <form action="enviar.php" method="POST" class="form-contacto">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required>

            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

            <button type="submit">Enviar</button>
        </form>
    </div>
</div>

EOS;

require("includes/comun/plantilla.php");
