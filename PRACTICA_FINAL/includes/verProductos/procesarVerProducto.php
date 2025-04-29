<?php
require_once(__DIR__ . "/../productos/productoAppService.php");
require_once(__DIR__ . "/../valoraciones/valoracionAppService.php");

class procesarVerProducto {
    public static function obtenerProducto($idProducto) {
        if (!$idProducto || !is_numeric($idProducto)) {
            return null;
        }

        $productoAppService = productoAppService::GetSingleton();
        return $productoAppService->obtenerProductoPorId($idProducto);
    }

    public static function obtenerValoracionesDeVendedor($idProducto) {
        $productoAppService = productoAppService::GetSingleton();
        $producto = $productoAppService->obtenerProductoPorId($idProducto);

        if (!$producto) return [];

        $idVendedor = $producto->getIdUsuario(); // el vendedor
        $valoracionService = valoracionAppService::GetSingleton();

        return $valoracionService->obtenerValoracionesPorVendedor($idVendedor);
    }

    public static function obtenerMediaValoracionVendedor($idUsuario) {
        $valoracionAppService = valoracionAppService::GetSingleton();
        return $valoracionAppService->obtenerMediaPorVendedor($idUsuario);
    }
    
}
?>
