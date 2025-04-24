<?php
require_once(__DIR__ . "/../productos/productoAppService.php");

class procesarVerProducto {
    public static function obtenerProducto($idProducto) {
        if (!$idProducto || !is_numeric($idProducto)) {
            return null;
        }

        $productoAppService = productoAppService::GetSingleton();
        return $productoAppService->obtenerProductoPorId($idProducto);
    }
}
