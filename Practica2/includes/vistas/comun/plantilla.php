<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?= $tituloPagina ?></title>
</head>

<body>

<div id="contenedor">

	<?php
		require("includes/vistas/comun/header.php");
	?>

	<main>
	  	<article>
			<?= $contenidoPrincipal ?>
		</article>
	</main>

	<?php
		require("includes/vistas/comun/footer.php");
	?>

</div> <!-- Fin del contenedor -->

</body>
</html>