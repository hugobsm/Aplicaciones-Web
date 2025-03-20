<?php

class ProductoDAO extends baseDAO {
    public function obtenerProductoPorId($id) {
        $sql = "SELECT * FROM productos WHERE id_producto = " . $this->realEscapeString($id);
        $resultado = $this->ExecuteQuery($sql);
        return $resultado ? new ProductoDTO(...array_values($resultado[0])) : null;
    }

    public function obtenerProductosPorUsuario($id_usuario) {
        $sql = "SELECT * FROM productos WHERE id_usuario = " . $this->realEscapeString($id_usuario);
        $resultado = $this->ExecuteQuery($sql);
        $productos = [];
        foreach ($resultado as $fila) {
            $productos[] = new ProductoDTO(...array_values($fila));
        }
        return $productos;
    }

    public function agregarProducto($producto) {
        $sql = "INSERT INTO productos (id_usuario, nombre_producto, descripcion, precio, imagen, fecha_publicacion) 
                VALUES ('" .
                $this->realEscapeString($producto->getIdUsuario()) . "', '" .
                $this->realEscapeString($producto->getNombre()) . "', '" .
                $this->realEscapeString($producto->getDescripcion()) . "', '" .
                $this->realEscapeString($producto->getPrecio()) . "', '" .
                $this->realEscapeString($producto->getImagen()) . "', '" .
                $this->realEscapeString($producto->getFechaPublicacion()) . "')";
        return $this->ExecuteCommand($sql);
    }

    public function eliminarProducto($id) {
        $sql = "DELETE FROM productos WHERE id_producto = " . $this->realEscapeString($id);
        return $this->ExecuteCommand($sql);
    }
}
