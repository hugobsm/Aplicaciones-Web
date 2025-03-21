<?php

require_once("productoFactory.php");

class productoAppService
{
    private static $instance=null;

    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct()
    {
    }
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new productoAppService();
        }
        return self::$instance;
    }
    
    public function publicarProducto($productoDTO)
    {
        $IProductoDAO = productoFactory::CreateProducto();
        return $IProductoDAO->crearProducto($productoDTO);
    }

    public function obtenerProducto($id)
    {
        $IProductoDAO = productoFactory::CreateProducto();
        return $IProductoDAO->obtenerProductoPorId($id);
    }

    public function obtenerProductosDeUsuario($id_usuario)
    {
        $IProductoDAO = productoFactory::CreateProducto();
        return $IProductoDAO->obtenerProductosPorUsuario($id_usuario);
    }

    public function obtenerTodosLosProductos()
    {
        $IProductoDAO = productoFactory::CreateProducto();
        return $IProductoDAO->obtenerTodosLosProductos();
    }

    public function eliminarProducto($id)
    {
        $IProductoDAO = productoFactory::CreateProducto();
        return $IProductoDAO->eliminarProducto($id);
    }
    public function obtenerProductoPorId($idProducto)
{
    $IProductoDAO = productoFactory::CreateProducto();
    return $IProductoDAO->obtenerProductoPorId($idProducto);
}

}

?>
