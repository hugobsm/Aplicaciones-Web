<?php

require_once("ICompra.php");
require_once("compraDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

class compraDAO extends baseDAO implements ICompra {
    public function realizarCompra($compraDTO) {
        $conn = application::getInstance()->getConexionBd();

        $query = "INSERT INTO compras (id_usuario, id_producto, fecha_compra, metodo_pago) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "iiss",
            $compraDTO->getIdUsuario(),
            $compraDTO->getIdProducto(),
            $compraDTO->getFechaCompra(),
            $compraDTO->getMetodoPago()
        );

        if ($stmt->execute()) {
            // Eliminar el producto de la tabla de productos después de la compra
            $deleteQuery = "DELETE FROM productos WHERE id_producto = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $compraDTO->getIdProducto());
            $deleteStmt->execute();
            return true;
        } else {
            error_log("❌ Error al procesar la compra: " . $stmt->error);
            return false;
        }
    }

    public function obtenerComprasPorUsuario($id_usuario) {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT * FROM compras WHERE id_usuario = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $compras = [];
        while ($fila = $resultado->fetch_assoc()) {
            $compras[] = new CompraDTO(...array_values($fila));
        }
        return $compras;
    }
}

?>
