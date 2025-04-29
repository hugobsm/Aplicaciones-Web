<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../compras/compraAppService.php';
require_once __DIR__ . '/../usuario/userAppService.php';

$tituloPagina = "Registro de Compras";
$compraService = compraAppService::GetSingleton();
$userService = userAppService::GetSingleton();

// Solo accesible para admin
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    $contenidoPrincipal = "<p>No tienes permiso para ver esta página.</p>";
} else {
    $compras = $compraService->obtenerTodasLasCompras();

    $contenidoPrincipal = "<h1>📄 Registro de Compras</h1>";
    $contenidoPrincipal .= "<table border='1' cellpadding='5' cellspacing='0'>";
    $contenidoPrincipal .= "<tr>
        <th>ID Compra</th>
        <th>Comprador</th>
        <th>Vendedor</th>
        <th>ID Producto</th>
        <th>Fecha</th>
        <th>Método de Pago</th>
    </tr>";

    foreach ($compras as $compra) {
        $comprador = $userService->getUserProfile($compra->getIdUsuario());
        $vendedor = $userService->getUserProfile($compra->getIdVendedor());

        $contenidoPrincipal .= "<tr>
            <td>{$compra->getIdCompra()}</td>
            <td>{$comprador->email()}</td>
            <td>{$vendedor->email()}</td>
            <td>{$compra->getIdProducto()}</td>
            <td>{$compra->getFechaCompra()}</td>
            <td>{$compra->getMetodoPago()}</td>
        </tr>";
    }

    $contenidoPrincipal .= "</table>";
}

require_once __DIR__ . '/../comun/plantilla.php';

?>
