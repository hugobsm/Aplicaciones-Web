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
    
    

    public function obtenerValoracionesPorVendedor($id_vendedor)
{
    $conn = application::getInstance()->getConexionBd();

    $sql = "SELECT v.*, u.email AS email_comprador
            FROM valoraciones v
            JOIN usuarios u ON v.id_comprador = u.id_usuario
            WHERE v.id_vendedor = ?
            ORDER BY v.fecha_valoracion DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_vendedor);
    $stmt->execute();

    $result = $stmt->get_result();

    $valoraciones = [];
    while ($fila = $result->fetch_assoc()) {
        // Añadimos un campo 'email_comprador' adicional
        $valoracionDTO = new ValoracionDTO(
            $fila['id_valoracion'],
            $fila['id_comprador'],
            $fila['id_vendedor'],
            $fila['puntuacion'],
            $fila['comentario'],
            $fila['fecha_valoracion']
        );
        $valoracionDTO->emailComprador = $fila['email_comprador']; // Propiedad pública temporal
        $valoraciones[] = $valoracionDTO;
    }

    return $valoraciones;
}

public function obtenerMediaPorVendedor($id_vendedor) {
    $conn = application::getInstance()->getConexionBd();
    $sql = "SELECT AVG(puntuacion) as media FROM valoraciones WHERE id_vendedor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_vendedor);
    $stmt->execute();
    $stmt->bind_result($media);
    $stmt->fetch();
    $stmt->close();
    return $media ?? 0;
}
}



?>
