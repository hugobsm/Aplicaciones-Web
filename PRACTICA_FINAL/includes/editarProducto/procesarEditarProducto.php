<?php
require_once(__DIR__ . "/../comun/formBase.php");
require_once(__DIR__ . "/../productos/productoAppService.php");
require_once(__DIR__ . "/../productos/productoDTO.php");

class editarProductoForm extends formBase
{
    public function __construct()
    {
        parent::__construct('editarProductoForm');
    }

    protected function CreateFields($datos)
    {
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        $id_producto = $_GET['id'] ?? null;

        if (!$id_usuario || !$id_producto) {
            return "<p class='error-message'>No tienes permiso para editar este producto.</p>";
        }

        $productoService = productoAppService::GetSingleton();
        $producto = $productoService->obtenerProductoPorId($id_producto);

        if (!$producto || $producto->getIdUsuario() != $id_usuario) {
            return "<p class='error-message'>No puedes editar este producto.</p>";
        }

        $nombre = htmlspecialchars($producto->getNombre());
        $descripcion = htmlspecialchars($producto->getDescripcion());
        $precio = htmlspecialchars($producto->getPrecio());
        $imagen = htmlspecialchars($producto->getImagen());

        $html = <<<HTML
        <div class="editar-producto-container">
            <h1>Editar Producto</h1>
            <form method="POST" class="editar-producto-form">
                <input type="hidden" name="id_producto" value="{$id_producto}">
                
                <label>Nombre:</label>
                <input type="text" name="nombre" value="{$nombre}" required>

                <label>Descripción:</label>
                <textarea name="descripcion" required>{$descripcion}</textarea>

                <label>Precio (€):</label>
                <input type="number" name="precio" step="0.01" value="{$precio}" required>

                <label>Imagen (URL):</label>
                <input type="text" name="imagen" value="{$imagen}">

                <button type="submit" name="editar">Guardar Cambios</button>
                <a href="profile.php" class="button-cancelar">Cancelar</a>
            </form>
        </div>
HTML;

        return $html;
    }

    protected function Process($datos)
    {
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        if (!$id_usuario) return "login.php";

        $id_producto = intval($datos['id_producto']);
        $productoService = productoAppService::GetSingleton();
        $producto = $productoService->obtenerProductoPorId($id_producto);

        if (!$producto || $producto->getIdUsuario() != $id_usuario) {
            return "profile.php";
        }

        $nombre = trim($datos['nombre']);
        $descripcion = trim($datos['descripcion']);
        $precio = floatval($datos['precio']);
        $imagen = trim($datos['imagen']);
        $fecha = $producto->getFechaPublicacion();

        $productoActualizado = new ProductoDTO(
            $id_producto,
            $id_usuario,
            $nombre,
            $descripcion,
            $precio,
            $fecha,
            $imagen
        );

        $productoService->actualizarProducto($productoActualizado);

        return "profile.php";
    }
}
?>
