<?php

class productoMock implements IProducto
{
    public function crearProducto($productoDTO)
    {
        return true;
    }

    public function obtenerProductoPorId($id)
    {
        return ["id" => $id, "nombre" => "Producto de prueba", "precio" => 10.0];
    }

    public function obtenerProductosPorUsuario($idUsuario)
    {
        return [
            ["id" => 1, "nombre" => "Producto 1", "precio" => 20.0],
            ["id" => 2, "nombre" => "Producto 2", "precio" => 35.0]
        ];
    }

    public function actualizarProducto($productoDTO)
    {
        return true;
    }

    public function eliminarProducto($id)
    {
        return true;
    }
}

?>
