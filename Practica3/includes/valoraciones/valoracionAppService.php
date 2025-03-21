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
        return $valoracionDAO->insertarValoracion($valoracionDTO);
    }

    public function obtenerValoracionesPorVendedor($id_vendedor) {
        $valoracionDAO = valoracionFactory::CreateValoracion();
        return $valoracionDAO->obtenerValoracionesPorVendedor($id_vendedor);
    }
}
?>
