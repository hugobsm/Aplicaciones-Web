<?php
include_once __DIR__ . "/../comun/formBase.php";
include_once __DIR__ . "/../valoraciones/valoracionAppService.php";

class valorarVendedorForm extends formBase {
    private $idVendedor;

    public function __construct($idVendedor) {
        parent::__construct('valorarVendedorForm');
        $this->idVendedor = $idVendedor;
    }

    protected function CreateFields($datos) {
        $idVendedor = $datos['id_vendedor'] ?? $this->idVendedor;
    
        if (!$idVendedor) {
            return "<p>Error: No se especificó un vendedor.</p>";
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
        </fieldset>
        <button type="submit">Enviar valoración</button>
    HTML;
    
        return $html;
    }
    
    
    

    private function selected($value, $expected) {
        return ($value == $expected) ? 'selected' : '';
    }

    protected function Process($datos) {
        
        $id_comprador = $_SESSION['id_usuario'] ?? null;
        $id_vendedor = intval($datos['id_vendedor'] ?? 0);
        $puntuacion = intval($datos['puntuacion'] ?? 0);
        $comentario = trim($datos['comentario'] ?? '');
    
        $id_comprador = filter_var($id_comprador, FILTER_SANITIZE_FULL_SPECIAL_CHARS);            
        $id_vendedor = filter_var($id_vendedor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $puntuacion = filter_var($puntuacion, FILTER_SANITIZE_NUMBER_INT);   
        $comentario = filter_var($comentario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$id_comprador || !$id_vendedor || !$puntuacion || empty($comentario)) {
            return ["Todos los campos son obligatorios."];
        }
    
        $fecha_valoracion = date("Y-m-d H:i:s");
    
       
    
        $valoracionDTO = new ValoracionDTO(0, $id_comprador, $id_vendedor, $puntuacion, $comentario, $fecha_valoracion);
        $valoracionService = valoracionAppService::GetSingleton();
    
        $ok = $valoracionService->insertarValoracion($valoracionDTO);
    
        if ($ok) {
            error_log("✅ Valoración insertada correctamente.");
        } else {
            error_log("❌ No se pudo insertar la valoración.");
        }
    
        return "profile.php";
    }
    
    
}
?>
