<?php
require_once("includes/config.php");
require_once("includes/verProductos/procesarVerProductos.php");

$tituloPagina = "Ver Productos";

$contenidoProductos = verProductos::mostrarTodos();

// Al principio de $contenidoPrincipal
$filtros = <<<HTML
<div class="filtros-container">
    <form method="GET" action="verProductos.php" class="form-filtros">
        <div class="filtro-grupo">
            <h3>Género</h3>
            <label><input type="checkbox" name="categorias[]" value="Mujer"> Mujer</label>
            <label><input type="checkbox" name="categorias[]" value="Hombre"> Hombre</label>
            <label><input type="checkbox" name="categorias[]" value="Unisex"> Unisex</label>
            <label><input type="checkbox" name="categorias[]" value="Niño"> Niño</label>
        </div>
        <div class="filtro-grupo">
            <h3>Tipo</h3>
            <label><input type="checkbox" name="categorias[]" value="Camisetas"> Camisetas</label>
            <label><input type="checkbox" name="categorias[]" value="Sudaderas"> Sudaderas</label>
            <label><input type="checkbox" name="categorias[]" value="Pantalones"> Pantalones</label>
            <label><input type="checkbox" name="categorias[]" value="Vestidos"> Vestidos</label>
        </div>
        <div class="filtro-grupo">
            <h3>Color</h3>
            <label><input type="checkbox" name="categorias[]" value="Color Verde"> Verde</label>
            <label><input type="checkbox" name="categorias[]" value="Color Azul"> Azul</label>
            <label><input type="checkbox" name="categorias[]" value="Color Rosa"> Rosa</label>
            <label><input type="checkbox" name="categorias[]" value="Color Negro"> Negro</label>
        </div>
        <div class="filtro-grupo">
            <h3>Talla</h3>
            <label><input type="checkbox" name="categorias[]" value="Talla S"> S</label>
            <label><input type="checkbox" name="categorias[]" value="Talla M"> M</label>
            <label><input type="checkbox" name="categorias[]" value="Talla L"> L</label>
            <label><input type="checkbox" name="categorias[]" value="Talla XL"> XL</label>
        </div>
        <button type="submit">Aplicar Filtros</button>
    </form>
</div>
HTML;


$contenidoPrincipal = <<<EOS
<h1>Lista de Productos</h1>
{$filtros}
<div class="productos-container">
{$contenidoProductos}
</div>
EOS;

require("includes/comun/plantilla.php");
?>
