<?php

require_once("ICompra.php");
require_once("compraDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

class compraDAO extends baseDAO implements ICompra {
    public function realizarCompra($compraDTO) {
        $conn = application::getInstance()->getConexionBd();
    
        $query = "INSERT INTO compras (id_usuario, id_producto, fecha_compra, metodo_pago, id_vendedor)
                  VALUES (?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "iissi",
            $compraDTO->getIdUsuario(),
            $compraDTO->getIdProducto(),
            $compraDTO->getFechaCompra(),
            $compraDTO->getMetodoPago(),
            $compraDTO->getIdVendedor()
        );
    
        if ($stmt->execute()) {
            // Eliminar producto después de comprar
            $deleteQuery = "DELETE FROM productos WHERE id_producto = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $compraDTO->getIdProducto());
            $deleteStmt->execute();
            return true;
        } else {

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

    public function insertarCompraYDevolverId($compra) {
        $conn = application::getInstance()->getConexionBd();
    
        // Paso 1: Obtener el precio desde la tabla productos
        $queryPrecio = "SELECT precio FROM productos WHERE id_producto = ?";
        $stmtPrecio = $conn->prepare($queryPrecio);
        $stmtPrecio->bind_param("i", $compra->getIdProducto());
        $stmtPrecio->execute();
        $result = $stmtPrecio->get_result();
    
        if ($row = $result->fetch_assoc()) {
            $precio = $row['precio']; // Puedes usarlo si quieres para algo más
        } else {
            throw new Exception("Producto no encontrado al obtener precio.");
        }
    
        // Paso 2: Insertar en compras
        $sql = "INSERT INTO compras (id_usuario, id_producto, metodo_pago) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", 
            $compra->getIdUsuario(), 
            $compra->getIdProducto(), 
            $compra->getMetodoPago()
        );
        $stmt->execute();
    
        return $stmt->insert_id;
    }



    public function obtenerTodasLasCompras() {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT * FROM compras ORDER BY fecha_compra DESC";
    
        $resultado = $conn->query($query);
        $compras = [];
    
        while ($fila = $resultado->fetch_assoc()) {
            $valores = array_values($fila);
            $compras[] = new CompraDTO(...$valores);
        }
    
        return $compras;
    }
    
}

?>
