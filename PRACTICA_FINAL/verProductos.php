<?php
require_once("includes/config.php");
require_once("includes/verProductos/procesarVerProductos.php");

$tituloPagina = "Ver Productos";

$contenidoProductos = verProductos::mostrarTodos();

$filtros = <<<HTML
<div class="menu-filtros">
    <div class="filtro-hover">
        <button class="btn-filtros">Filtros</button>
        <div class="filtro-categorias">
            <form method="GET" action="verProductos.php" class="form-filtros">
                <div class="categoria">
                    <span>Género ▾</span>
                    <div class="subcategoria">
                        <label><input type="checkbox" name="categorias[]" value="Mujer"> Mujer</label>
                        <label><input type="checkbox" name="categorias[]" value="Hombre"> Hombre</label>
                        <label><input type="checkbox" name="categorias[]" value="Unisex"> Unisex</label>
                        <label><input type="checkbox" name="categorias[]" value="Niño"> Niño</label>
                    </div>
                </div>
                <div class="categoria">
                    <span>Tipo ▾</span>
                    <div class="subcategoria">
                        <label><input type="checkbox" name="categorias[]" value="Camisetas"> Camisetas</label>
                        <label><input type="checkbox" name="categorias[]" value="Sudaderas"> Sudaderas</label>
                        <label><input type="checkbox" name="categorias[]" value="Pantalones"> Pantalones</label>
                        <label><input type="checkbox" name="categorias[]" value="Vestidos"> Vestidos</label>
                        <label><input type="checkbox" name="categorias[]" value="Blusas"> Blusas</label>
                        <label><input type="checkbox" name="categorias[]" value="Abrigos"> Abrigos</label>
                        <label><input type="checkbox" name="categorias[]" value="Tops"> Tops</label>
                        <label><input type="checkbox" name="categorias[]" value="Accesorios"> Accesorios</label>
                        <label><input type="checkbox" name="categorias[]" value="Calzado"> Calzado</label>
                    </div>
                </div>
                <div class="categoria">
                    <span>Color ▾</span>
                    <div class="subcategoria">
                        <label><input type="checkbox" name="categorias[]" value="Color Verde"> Verde</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Azul"> Azul</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Rosa"> Rosa</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Negro"> Negro</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Amarillo"> Amarillo</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Naranja"> Naranja</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Rojo"> Rojo</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Morado"> Morado</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Lila"> Lila</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Marrón"> Marrón</label>
                        <label><input type="checkbox" name="categorias[]" value="Color Blanco"> Blanco</label>
                    </div>
                </div>
                <div class="categoria">
                    <span>Talla ▾</span>
                    <div class="subcategoria">
                        <label><input type="checkbox" name="categorias[]" value="Talla XS"> XS</label>
                        <label><input type="checkbox" name="categorias[]" value="Talla S"> S</label>
                        <label><input type="checkbox" name="categorias[]" value="Talla M"> M</label>
                        <label><input type="checkbox" name="categorias[]" value="Talla L"> L</label>
                        <label><input type="checkbox" name="categorias[]" value="Talla XL"> XL</label>
                    </div>
                </div>
                <div class="aplicar-wrap"><button class="btn-aplicar" type="submit">Aplicar filtros</button></div>
            </form>
        </div>
    </div>
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
