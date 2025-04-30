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
        require_once(__DIR__ . '/../usuario/userAppService.php');
        $userService = userAppService::GetSingleton();
    
        $idComprador = $compraDTO->getIdUsuario();
        $idVendedor = $compraDTO->getIdVendedor();
        $idProducto = $compraDTO->getIdProducto();
    
        // Obtener precio del producto
        $conn = application::getInstance()->getConexionBd();
        $stmt = $conn->prepare("SELECT precio FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        $stmt->bind_result($precio);
        $stmt->fetch();
        $stmt->close();
    
        // Verificar si el comprador tiene suficiente saldo
        $comprador = $userService->getUserProfile($idComprador);
        if ($comprador->saldo() < $precio) {
            error_log("❌ Saldo insuficiente para realizar la compra.");
            return false; // 🚫 Cancela la compra
        }
    
        // Realizar la compra
        $ICompraDAO = compraFactory::CreateCompra();
        $resultado = $ICompraDAO->realizarCompra($compraDTO);
    
        if ($resultado) {
            // Actualizar saldos
            $userService->restarSaldo($idComprador, $precio);
            $userService->sumarSaldo($idVendedor, $precio);
        }
    
        return $resultado;
    }
    

    public function obtenerComprasPorUsuario($id_usuario) {
        $ICompraDAO = compraFactory::CreateCompra();
        return $ICompraDAO->obtenerComprasPorUsuario($id_usuario);
    }

    public function crearCompraPendiente($id_usuario, $id_producto, $precio, $metodo) {
        $ICompraDAO = compraFactory::CreateCompra();
    
        // Obtener el vendedor desde el producto
        require_once(__DIR__ . '/../productos/productoAppService.php');
        $productoService = productoAppService::GetSingleton();
        $producto = $productoService->obtenerProductoPorId($id_producto);
        $id_vendedor = $producto ? $producto->getIdUsuario() : null;
    
        // Validación básica
        if (!$id_vendedor) {
            throw new Exception("No se pudo obtener el vendedor del producto.");
        }
    
        $fecha_compra = date('Y-m-d H:i:s');
    
        // Crear el DTO correctamente con setters
        $compra = new CompraDTO(null, $id_usuario, $id_producto, $fecha_compra, $metodo, $id_vendedor);
        /*$compra->setIdUsuario((int)$id_usuario);
        $compra->setIdProducto((int)$id_producto);
        $compra->setFechaCompra($fecha_compra);
        $compra->setMetodoPago($metodo);
        $compra->setIdVendedor((int)$id_vendedor);
    */
        return $ICompraDAO->insertarCompraYDevolverId($compra);
    }

    
    public function obtenerTodasLasCompras() {
        $ICompraDAO = compraFactory::CreateCompra();
        return $ICompraDAO->obtenerTodasLasCompras();
    }
    
}
?>
