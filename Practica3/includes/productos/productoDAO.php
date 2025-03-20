<?php

require_once("IProducto.php");
require_once("productoDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

class productoDAO extends baseDAO implements IProducto
{
    public function crearProducto($productoDTO)
    {
        $conn = application::getInstance()->getConexionBd();

        $query = "INSERT INTO productos (id_usuario, nombre_producto, descripcion, precio, imagen, fecha_publicacion)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "issdss",
            $productoDTO->getIdUsuario(),
            $productoDTO->getNombre(),
            $productoDTO->getDescripcion(),
            $productoDTO->getPrecio(),
            $productoDTO->getImagen(),
            $productoDTO->getFechaPublicacion()
        );

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("❌ Error al insertar producto: " . $stmt->error);
            return false;
        }
    }

    public function obtenerProductoPorId($id)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos WHERE id_producto = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($fila = $resultado->fetch_assoc()) {
            return new ProductoDTO(...array_values($fila));
        }

        return null;
    }

    public function obtenerProductosPorUsuario($id_usuario)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos WHERE id_usuario = ? ORDER BY fecha_publicacion DESC";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = new ProductoDTO(...array_values($fila));
        }

        return $productos;
    }

    public function obtenerTodosLosProductos()
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT * FROM productos ORDER BY fecha_publicacion DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = new ProductoDTO(...array_values($fila));
        }

        return $productos;
    }

    public function eliminarProducto($id)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "DELETE FROM productos WHERE id_producto = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
?>