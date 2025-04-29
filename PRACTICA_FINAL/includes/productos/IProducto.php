<?php

interface IProducto
{
    public function crearProducto($productoDTO);
    
    public function obtenerProductoPorId($id);
    
    public function obtenerProductosPorUsuario($idUsuario);
    
    public function actualizarProducto($productoDTO);
    
    public function eliminarProducto($id);

    public function obtenerTodosLosProductos();

    public function obtenerProductosPaginados($offset, $limite, $id_usuario_actual = null);
}
?>
