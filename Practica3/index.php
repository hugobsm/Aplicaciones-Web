<?php

require_once("includes/config.php");

$tituloPagina = 'Portada';

$app = application::getInstance();

$mensaje = $app->getAtributoPeticion('mensaje');
		
$contenidoPrincipal=<<<EOS
	<h1>Página principal</h1>
	<p> $mensaje</p>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require("includes/comun/plantilla.php");
?>