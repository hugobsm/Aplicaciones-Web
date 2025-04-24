<?php

require_once("compraFactory.php");

class compraAppService {
    private static $instance;

    public static function GetSingleton() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {}

    public function realizarCompra($compraDTO) {
        $ICompraDAO = compraFactory::CreateCompra();
        return $ICompraDAO->realizarCompra($compraDTO);
    }

    public function obtenerComprasPorUsuario($id_usuario) {
        $ICompraDAO = compraFactory::CreateCompra();
        return $ICompraDAO->obtenerComprasPorUsuario($id_usuario);
    }
}

?>
