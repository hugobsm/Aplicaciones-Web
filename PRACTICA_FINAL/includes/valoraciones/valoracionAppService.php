<?php
require_once("valoracionFactory.php");

class valoracionAppService {
    private static $instance = null;

    public static function GetSingleton() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function insertarValoracion($valoracionDTO) {
        $valoracionDAO = valoracionFactory::CreateValoracion();
        $ok = $valoracionDAO->insertarValoracion($valoracionDTO);
        
        if (!$ok) {
            error_log("❌ valoracionAppService: Error al insertar valoración.");
        }
        
        return $ok;
    }
    

    public function obtenerValoracionesPorVendedor($id_vendedor) {
        $valoracionDAO = valoracionFactory::CreateValoracion();
        return $valoracionDAO->obtenerValoracionesPorVendedor($id_vendedor);
    }

    public function obtenerMediaPorVendedor($id_vendedor) {
        $valoracionDAO = valoracionFactory::CreateValoracion();
        return $valoracionDAO->obtenerMediaPorVendedor($id_vendedor);
    }
    
    public function existeValoracionPorProducto($id_comprador, $id_producto) {
        $valoracionDAO = valoracionFactory::CreateValoracion();
        return $valoracionDAO->existeValoracionPorProducto($id_comprador, $id_producto);
    }
    
    
}
?>
