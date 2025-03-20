<?php
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../compras/compraAppService.php";

class comprarProductoForm extends formBase {
    private $idProducto;

    public function __construct($idProducto) {
        parent::__construct('comprarProductoForm');
        $this->idProducto = $idProducto;
    }

    protected function CreateFields($datos) {
        $html = <<<EOF
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
EOF;
        return $html;
    }

    protected function Process($datos) {
        if (!isset($_SESSION['id_usuario'])) {
            return ["Debes iniciar sesión para comprar."];
        }
        error_log("🛒 Iniciando procesarCompra.php...");

        $id_usuario = $_SESSION['id_usuario'];
        $id_producto = trim($datos['id_producto'] ?? '');
        $metodo_pago = trim($datos['metodo_pago'] ?? '');

        if (empty($id_producto) || empty($metodo_pago)) {
            return ["Debe seleccionarse un método de pago."];
        }

        $compraDTO = new CompraDTO(0, $id_usuario, $id_producto, date("Y-m-d H:i:s"), $metodo_pago);
        $compraAppService = compraAppService::GetSingleton();
        error_log("🛒 Iniciando procesarCompra.php...");

        try {
            $compraAppService->realizarCompra($compraDTO);
            header("Location: confirmacionCompra.php");
            exit();
        } catch (Exception $e) {
            return [$e->getMessage()];
        }
    }

}
?>
