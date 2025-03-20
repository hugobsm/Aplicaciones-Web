<?php

class ProductoService {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function obtenerProducto($id) {
        return $this->productoDAO->obtenerProductoPorId($id);
    }

    public function obtenerProductosDeUsuario($id_usuario) {
        return $this->productoDAO->obtenerProductosPorUsuario($id_usuario);
    }

    public function publicarProducto($id_usuario, $nombre, $descripcion, $precio, $imagen) {
        $fecha_publicacion = date("Y-m-d H:i:s");
        $producto = new ProductoDTO(null, $id_usuario, $nombre, $descripcion, $precio, $imagen, $fecha_publicacion);
        return $this->productoDAO->agregarProducto($producto);
    }

    public function eliminarProducto($id) {
        return $this->productoDAO->eliminarProducto($id);
    }
}