<!DOCTYPE html>
<html>
<head>
    <!-- Usamos RUTA_CSS para construir la ruta absoluta del archivo CSS -->
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilo.css?v=<?php echo time(); ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $tituloPagina ?></title>
</head>


<body>

<div id="contenedor">

	<?php
		//require("includes/comun/cabecera.php");
		require(__DIR__ . "/cabecera.php");
	?>

	<main>
	  	<article>
			<?= $contenidoPrincipal ?>
		</article>
	</main>

	<?php
		//require("includes/comun/pie.php");
		require(__DIR__ . "/pie.php");
	?>

</div> <!-- Fin del contenedor -->

</body>
</html>