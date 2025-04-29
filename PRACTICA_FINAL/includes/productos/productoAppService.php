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

    public function obtenerTodosLosProductos($id_usuario_actual = null)
    {
        $IProductoDAO = productoFactory::CreateProducto();
        return $IProductoDAO->obtenerTodosLosProductos($id_usuario_actual);
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

public function obtenerProductosPorCategorias($nombresCategorias) {
    $IProductoDAO = productoFactory::CreateProducto();
    return $IProductoDAO->obtenerProductosPorCategorias($nombresCategorias);
}

public function obtenerPrecioMaximo() {
    $conn = Application::getInstance()->getConexionBd();
    $query = "SELECT MAX(precio) AS max_precio FROM productos";
    $res = $conn->query($query);
    if ($fila = $res->fetch_assoc()) {
        return (float) $fila['max_precio'] ?? 500;
    }
    return 500; // Por defecto
}


public function obtenerProductosPaginados($pagina, $id_usuario_actual = null) {

    $IProductoDAO = productoFactory::CreateProducto();
    $limite = 12; // 12 productos por página
    $offset = ($pagina - 1) * $limite;
    
    return $IProductoDAO->obtenerProductosPaginados($offset, $limite, $id_usuario_actual);
}

}

?>
