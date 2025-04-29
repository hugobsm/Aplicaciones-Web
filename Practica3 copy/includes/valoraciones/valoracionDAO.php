<?php
require_once("IValoracion.php");
require_once("valoracionDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

class valoracionDAO extends baseDAO implements IValoracion {
    
    public function insertarValoracion($valoracionDTO) {
        $conn = application::getInstance()->getConexionBd();
    
        $query = "INSERT INTO valoraciones (id_comprador, id_vendedor, puntuacion, comentario, fecha_valoracion)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
    
        if (!$stmt) {
            error_log("❌ Error al preparar la consulta: " . $conn->error);
            return false;
        }
    
        $id_comprador = $valoracionDTO->getIdComprador();
        $id_vendedor = $valoracionDTO->getIdVendedor();
        $puntuacion = $valoracionDTO->getPuntuacion();
        $comentario = $valoracionDTO->getComentario();
        $fecha = $valoracionDTO->getFechaValoracion();
    
        $stmt->bind_param("iiiss", $id_comprador, $id_vendedor, $puntuacion, $comentario, $fecha);
    
        if (!$stmt->execute()) {
            error_log("❌ Error al ejecutar la consulta: " . $stmt->error);
            return false;
        }
    
        return true;
    }
    
    

    public function obtenerValoracionesPorVendedor($id_vendedor) {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT * FROM valoraciones WHERE id_vendedor = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_vendedor);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $valoraciones = [];
        while ($fila = $resultado->fetch_assoc()) {
            $valoraciones[] = new ValoracionDTO(...array_values($fila));
        }
        return $valoraciones;
    }
}
?>
