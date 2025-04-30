<?php
require_once(__DIR__ . "/../comun/formBase.php");
require_once(__DIR__ . "/../productos/productoAppService.php");

class eliminarProductoForm extends formBase 
{
    public function __construct()
    {
        parent::__construct('eliminarProductoForm');
    }

    protected function CreateFields($datos)
    {
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        $id_producto = $_GET['id'] ?? null;

        if (!$id_usuario || !$id_producto) {
            return "<p class='error-message'>No tienes permiso para eliminar este producto.</p>";
        }

        $productoService = productoAppService::GetSingleton();
        $producto = $productoService->obtenerProductoPorId($id_producto);

        if (!$producto || $producto->getIdUsuario() != $id_usuario) {
            return "<p class='error-message'>No puedes eliminar este producto.</p>";
        }

        $nombre = htmlspecialchars($producto->getNombre());

        $html = <<<HTML
        <div class="eliminar-confirm">
            <h1>¿Eliminar producto?</h1>
            <p>¿Estás seguro de que deseas eliminar <strong>{$nombre}</strong>?</p>
            <form method="POST" class="eliminar-form">
                <input type="hidden" name="id_producto" value="{$id_producto}">
                <button type="submit" name="confirmar">Sí, eliminar</button>
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

        if ($producto && $producto->getIdUsuario() == $id_usuario) {
            $productoService->eliminarProducto($id_producto);
        }

        return "profile.php";
    }
}
?>