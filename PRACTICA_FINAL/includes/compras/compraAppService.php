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
        $resultado = $ICompraDAO->realizarCompra($compraDTO);

        if ($resultado) {
            // Obtenemos los IDs
            $idComprador = $compraDTO->getIdUsuario();
            $idVendedor = $compraDTO->getIdVendedor();
            $idProducto = $compraDTO->getIdProducto();

            // Obtenemos el precio del producto desde la BD
            $conn = application::getInstance()->getConexionBd();
            $stmt = $conn->prepare("SELECT precio FROM productos WHERE id_producto = ?");
            $stmt->bind_param("i", $idProducto);
            $stmt->execute();
            $stmt->bind_result($precio);
            $stmt->fetch();
            $stmt->close();

            // Actualizamos saldos
            require_once(__DIR__ . '/../usuario/userAppService.php');
            $userService = userAppService::GetSingleton();
            $userService->restarSaldo($idComprador, $precio);
            $userService->sumarSaldo($idVendedor, $precio);
        }

        return $resultado;
    }

    public function obtenerComprasPorUsuario($id_usuario) {
        $ICompraDAO = compraFactory::CreateCompra();
        return $ICompraDAO->obtenerComprasPorUsuario($id_usuario);
    }
}
?>
