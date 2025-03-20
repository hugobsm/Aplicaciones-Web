<?php

class productoMock implements IProducto
{
    public function crearProducto($productoDTO)
    {
        return true;
    }

    public function obtenerProductoPorId($id)
    {
        return new ProductoDTO($id, 1, "Mock Producto", "Descripción de prueba", 10.00, "imagen.jpg", "2025-03-20");
    }

    public function obtenerProductosPorUsuario($id_usuario)
    {
        return [
            new ProductoDTO(1, $id_usuario, "Producto 1", "Desc 1", 20.00, "imagen1.jpg", "2025-03-20"),
            new ProductoDTO(2, $id_usuario, "Producto 2", "Desc 2", 35.00, "imagen2.jpg", "2025-03-21")
        ];
    }

    public function obtenerTodosLosProductos()
    {
        return [
            new ProductoDTO(1, 1, "Producto A", "Desc A", 50.00, "imagenA.jpg", "2025-03-20"),
            new ProductoDTO(2, 2, "Producto B", "Desc B", 75.00, "imagenB.jpg", "2025-03-21")
        ];
    }

    public function eliminarProducto($id)
    {
        return true;
    }
    public function actualizarProducto($productoDTO)
    {
        // Simulación de actualización, retorna true como si hubiera funcionado
        return true;
    }
     
}
?>