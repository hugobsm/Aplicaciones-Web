<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../compras/compraAppService.php';
require_once __DIR__ . '/../usuario/userAppService.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=registro_compras.xls");
header("Pragma: no-cache");
header("Expires: 0");

$compraService = compraAppService::GetSingleton();
$userService = userAppService::GetSingleton();
$compras = $compraService->obtenerTodasLasCompras();

echo "<table border='1'>";
echo "<tr>
        <th>ID Compra</th>
        <th>Comprador</th>
        <th>Vendedor</th>
        <th>ID Producto</th>
        <th>Fecha</th>
        <th>Método de Pago</th>
      </tr>";

foreach ($compras as $compra) {
    $comprador = $userService->getUserProfile($compra->getIdUsuario());
    $vendedor  = $userService->getUserProfile($compra->getIdVendedor());

    echo "<tr>";
    echo "<td>{$compra->getIdCompra()}</td>";
    echo "<td>" . ($comprador ? $comprador->email() : 'N/A') . "</td>";
    echo "<td>" . ($vendedor ? $vendedor->email() : 'N/A') . "</td>";
    echo "<td>{$compra->getIdProducto()}</td>";
    echo "<td>{$compra->getFechaCompra()}</td>";
    echo "<td>{$compra->getMetodoPago()}</td>";
    echo "</tr>";
}

echo "</table>";
exit();
?>
