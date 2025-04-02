<?php
require_once(__DIR__ . "/../compras/compraAppService.php");
require_once(__DIR__ . "/../productos/productoAppService.php");
require_once(__DIR__ . "/../comun/formBase.php");

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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ["Error: El formulario debe enviarse mediante POST."];
        }

        $id_producto = intval($datos['id_producto'] ?? 0);
        $metodo_pago = trim($datos['metodo_pago'] ?? '');
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_usuario || !$id_producto || !$metodo_pago) {
            return ["Faltan datos obligatorios para completar la compra."];
        }

        // Validación básica de seguridad (escapar entrada de usuario)
        $metodo_pago = htmlspecialchars($metodo_pago, ENT_QUOTES, 'UTF-8');

        $productoService = productoAppService::GetSingleton();
        $producto = $productoService->obtenerProductoPorId($id_producto);

        if (!$producto) {
            return ["El producto seleccionado no existe."];
        }

        $id_vendedor = $producto->getIdUsuario();
        $fecha_compra = date("Y-m-d H:i:s");

        $compraDTO = new CompraDTO(
            0,
            $id_usuario,
            $id_producto,
            $fecha_compra,
            $metodo_pago,
            $id_vendedor
        );

        $compraService = compraAppService::GetSingleton();
        $compraService->realizarCompra($compraDTO);
        $productoService->eliminarProducto($id_producto);

        header("Location: confirmacionCompra.php");
        exit();
    }
}
