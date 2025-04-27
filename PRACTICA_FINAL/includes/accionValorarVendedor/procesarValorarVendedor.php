<?php
include_once __DIR__ . "/../comun/formBase.php";
include_once __DIR__ . "/../valoraciones/valoracionAppService.php";

class valorarVendedorForm extends formBase {
    private $idVendedor;
    private $idProducto;

    public function __construct($idVendedor, $idProducto) {
        parent::__construct('valorarVendedorForm');
        $this->idVendedor = $idVendedor;
        $this->idProducto = $idProducto;
    }

    protected function CreateFields($datos) {
        $idVendedor = $datos['id_vendedor'] ?? $this->idVendedor;
        $idProducto = $datos['id_producto'] ?? $this->idProducto;

        if (!$idVendedor || !$idProducto) {
            return "<p>Error: No se especificó un vendedor o producto.</p>";
        }

        $puntuacion = $datos['puntuacion'] ?? '';
        $comentario = htmlspecialchars($datos['comentario'] ?? '');

        $html = <<<HTML
        <fieldset>
            <legend>Valorar al vendedor (ID: {$idVendedor})</legend>
            <p>
                <label for="puntuacion">Puntuación:</label>
                <select name="puntuacion" required>
                    <option value="">-- Selecciona --</option>
                    <option value="1" {$this->selected($puntuacion, 1)}>1 ⭐</option>
                    <option value="2" {$this->selected($puntuacion, 2)}>2 ⭐⭐</option>
                    <option value="3" {$this->selected($puntuacion, 3)}>3 ⭐⭐⭐</option>
                    <option value="4" {$this->selected($puntuacion, 4)}>4 ⭐⭐⭐⭐</option>
                    <option value="5" {$this->selected($puntuacion, 5)}>5 ⭐⭐⭐⭐⭐</option>
                </select>
            </p>
            <p>
                <label for="comentario">Comentario:</label><br/>
                <textarea name="comentario" rows="4" cols="50" required>$comentario</textarea>
            </p>
            <input type="hidden" name="id_vendedor" value="$idVendedor" />
            <input type="hidden" name="id_producto" value="$idProducto" />
        </fieldset>
        <button type="submit">Enviar valoración</button>
HTML;

        return $html;
    }

    private function selected($value, $expected) {
        return ($value == $expected) ? 'selected' : '';
    }

    protected function Process($datos) {
        var_dump($datos);
        exit;
        $id_comprador = $_SESSION['id_usuario'] ?? null;
        $id_vendedor = intval($datos['id_vendedor'] ?? 0);
        $id_producto = intval($datos['id_producto'] ?? 0);
        $puntuacion = intval($datos['puntuacion'] ?? 0);
        $comentario = trim($datos['comentario'] ?? '');

        if (!$id_comprador || !$id_vendedor || !$id_producto || !$puntuacion || empty($comentario)) {
            return ["Todos los campos son obligatorios."];
        }

        $valoracionService = valoracionAppService::GetSingleton();

        if ($valoracionService->existeValoracionPorProducto($id_comprador, $id_producto)) {
            return ["Ya has valorado este producto."];
        }

        $fecha_valoracion = date("Y-m-d H:i:s");
        $valoracionDTO = new ValoracionDTO(0, $id_comprador, $id_vendedor, $id_producto, $puntuacion, $comentario, $fecha_valoracion);
        $ok = $valoracionService->insertarValoracion($valoracionDTO);

        return $ok ? "profile.php" : ["❌ No se pudo insertar la valoración."];
    }
}
?>
