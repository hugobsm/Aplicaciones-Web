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
        
$id_usuario = $productoDTO->getIdUsuario();
$nombre = $productoDTO->getNombre();
$descripcion = $productoDTO->getDescripcion();
$precio = $productoDTO->getPrecio();
$imagen = $productoDTO->getImagen();
$fecha_publicacion = $productoDTO->getFechaPublicacion();

//escapar realEscapeString

// Luego pásalas a bind_param()
$stmt->bind_param("issdss", $id_usuario, $nombre, $descripcion, $precio, $imagen, $fecha_publicacion);


        if ($stmt->execute()) {
            return true;
        } else {
            error_log("❌ Error al insertar producto: " . $stmt->error);
            return false;
        }
    }

    public function obtenerProductoPorId($id) {
        error_log("🔍 Buscando producto con ID: $id");
        
        $conn = application::getInstance()->getConexionBd();
        $sql = "SELECT id_producto, id_usuario, nombre_producto, descripcion, precio, imagen, fecha_publicacion 
                FROM productos WHERE id_producto = ?";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("❌ Error preparando consulta: " . $conn->error);
            return null;
        }
    
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("❌ Error ejecutando consulta: " . $stmt->error);
            return null;
        }
    
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            error_log("✅ Producto encontrado: " . json_encode($fila));
            return new ProductoDTO(
                $fila['id_producto'],
                $fila['id_usuario'],
                $fila['nombre_producto'],
                $fila['descripcion'],
                $fila['precio'],
                $fila['imagen'],
                $fila['fecha_publicacion']
            );
        } else {
            error_log("⚠️ Producto con ID $id no encontrado.");
            return null;
        }
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

    /*public function obtenerTodosLosProductos()
    {
        $sql = "SELECT * FROM productos ORDER BY fecha_publicacion DESC";
        $resultado = $this->ExecuteQuery($sql);
    
        $productos = [];
        foreach ($resultado as $fila) {
            $productos[] = new ProductoDTO(...array_values($fila));
        }
        return $productos;
    }*/
    public function obtenerTodosLosProductos($id_usuario_actual = null)
    {
    $conn = application::getInstance()->getConexionBd();

    // Modificar la consulta para excluir los productos del usuario actual si se proporciona un ID
    $query = "SELECT * FROM productos";
    if ($id_usuario_actual !== null) {
        $query .= " WHERE id_usuario != ?"; // Excluir productos del usuario actual
    }
    $query .= " ORDER BY fecha_publicacion DESC";

    $stmt = $conn->prepare($query);

    if ($id_usuario_actual !== null) {
        $stmt->bind_param("i", $id_usuario_actual);
    }

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

    public function actualizarProducto($productoDTO)
    {
        $sql = "UPDATE productos SET 
                nombre_producto = '" . $this->realEscapeString($productoDTO->getNombre()) . "',
                descripcion = '" . $this->realEscapeString($productoDTO->getDescripcion()) . "',
                precio = '" . $this->realEscapeString($productoDTO->getPrecio()) . "',
                imagen = '" . $this->realEscapeString($productoDTO->getImagen()) . "'
            WHERE id_producto = " . $this->realEscapeString($productoDTO->getId());

        return $this->ExecuteCommand($sql);
    }
 


}
?>