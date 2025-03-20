<?php
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../compras/compraAppService.php";
include __DIR__ . "/../productos/productoAppService.php";

class comprarProductoForm extends formBase {
    private $idProducto;

    public function __construct($idProducto) {
        parent::__construct('comprarProductoForm');
        $this->idProducto = $idProducto;
    }

    protected function CreateFields($datos) {
        $html = <<<EOF
        <form method="POST" action="{$_SERVER['PHP_SELF']}">
            <fieldset>
                <legend>Confirmar Compra</legend>
                <p><label>Método de Pago:</label> 
                    <select name="metodo_pago" required>
                        <option value="Tarjeta">Tarjeta de Crédito</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Transferencia">Transferencia Bancaria</option>
                    </select>
                </p>
                <input type="hidden" name="id_producto" value="{$this->idProducto}">
                <button type="submit" name="comprar">Confirmar Compra</button>
            </fieldset>
        </form>
    EOF;
        return $html;
    }

    protected function Process($datos) { 
        error_log("🛒 Intentando realizar la compra...");

        // ✅ Verificar si el formulario se envió correctamente
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("❌ ERROR: El formulario NO se envió por POST.");
        }

        if (empty($datos['id_producto']) || empty($datos['metodo_pago'])) {
            die("❌ ERROR: Datos incompletos.");
        }

        // ✅ Obtener valores del formulario
        $id_producto = intval($datos['id_producto']);
        $metodo_pago = trim($datos['metodo_pago']);
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_usuario) {
            die("❌ ERROR: Debes iniciar sesión para comprar.");
        }

        error_log("🆔 ID Producto: " . $id_producto);
        error_log("👤 ID Usuario: " . $id_usuario);
        error_log("💳 Método Pago: " . $metodo_pago);

        // ✅ Verificar si el producto existe
        $productoAppService = productoAppService::GetSingleton();
        $producto = $productoAppService->obtenerProductoPorId($id_producto);

        if (!$producto) {
            die("❌ ERROR: El producto con ID $id_producto no existe.");
        }

        // ✅ Insertar la compra en la base de datos
        $compraDTO = new CompraDTO(0, $id_usuario, $id_producto, date("Y-m-d H:i:s"), $metodo_pago);
        $compraAppService = compraAppService::GetSingleton();

        try {
            $compraAppService->realizarCompra($compraDTO);
            error_log("✅ Compra registrada en la base de datos.");

            // ✅ Eliminar el producto de la base de datos
            $productoAppService->eliminarProducto($id_producto);
            error_log("🗑️ Producto eliminado de la base de datos.");

            // ✅ Redirigir a confirmación
            header("Location: confirmacionCompra.php");
            exit();
        } catch (Exception $e) {
            error_log("❌ Error en la compra: " . $e->getMessage());
            die("❌ ERROR: " . $e->getMessage());
        }
    }
}
?>
