<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../compras/compraAppService.php';
require_once __DIR__ . '/../usuario/userAppService.php';

$tituloPagina = "Registro de Compras";

$compraService = compraAppService::GetSingleton();
$userService = userAppService::GetSingleton();

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    $contenidoPrincipal = "<p>No tienes permiso para ver esta página.</p>";
} else {
    $filtroComprador = $_GET['comprador'] ?? '';
    $filtroVendedor = $_GET['vendedor'] ?? '';
    $filtroMetodo   = $_GET['metodo'] ?? '';

    $compras = $compraService->obtenerTodasLasCompras();

    ob_start();

    echo "<h1 style='margin-bottom: 20px;'>📄 Registro de Compras</h1>";

    echo <<<HTML
    <form method="GET" style="margin-bottom: 30px; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <label><strong>Comprador:</strong></label>
        <input type="text" name="comprador" value="{$filtroComprador}" style="padding: 4px 8px; width: 180px;">

        <label><strong>Vendedor:</strong></label>
        <input type="text" name="vendedor" value="{$filtroVendedor}" style="padding: 4px 8px; width: 180px;">

        <label><strong>Método de Pago:</strong></label>
HTML;

    echo '<select name="metodo" style="padding: 4px 8px;">';
    echo '<option value="" ' . ($filtroMetodo === '' ? 'selected' : '') . '>Todos</option>';
    echo '<option value="Saldo" ' . ($filtroMetodo === 'Saldo' ? 'selected' : '') . '>Saldo</option>';
    echo '<option value="Tarjeta" ' . ($filtroMetodo === 'Tarjeta' ? 'selected' : '') . '>Tarjeta</option>';
    echo '<option value="PayPal" ' . ($filtroMetodo === 'PayPal' ? 'selected' : '') . '>PayPal</option>';
    echo '<option value="Transferencia" ' . ($filtroMetodo === 'Transferencia' ? 'selected' : '') . '>Transferencia</option>';
    echo '</select>';

    echo <<<HTML
        <button type="submit" style="background-color: black; color: white; padding: 6px 16px; border: none; cursor: pointer; font-weight: bold;">
            Filtrar
        </button>

        <a href="verCompras.php" style="background-color: #ccc; color: black; padding: 6px 16px; text-decoration: none; font-weight: bold; border: 1px solid #999;">
            Deshacer filtros
        </a>

        <a href="exportarCompras.php" style="background-color: green; color: white; padding: 6px 16px; text-decoration: none; font-weight: bold; border: 1px solid #999;">
            Exportar a Excel
        </a>
    </form>
HTML;

    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>
        <th>ID Compra</th>
        <th>Comprador</th>
        <th>Vendedor</th>
        <th>ID Producto</th>
        <th>Fecha</th>
        <th>Método de Pago</th>
    </tr>";

    foreach ($compras as $compra) {
        $compradorObj = $userService->getUserProfile($compra->getIdUsuario());
        $vendedorObj  = $userService->getUserProfile($compra->getIdVendedor());

        $compradorEmail = $compradorObj ? $compradorObj->email() : 'N/A';
        $vendedorEmail  = $vendedorObj  ? $vendedorObj->email()  : 'N/A';
        $metodoPago     = $compra->getMetodoPago();

        if (
            ($filtroComprador && stripos($compradorEmail, $filtroComprador) === false) ||
            ($filtroVendedor && stripos($vendedorEmail, $filtroVendedor) === false) ||
            ($filtroMetodo && $metodoPago !== $filtroMetodo)
        ) {
            continue;
        }

        echo "<tr>
            <td>{$compra->getIdCompra()}</td>
            <td>{$compradorEmail}</td>
            <td>{$vendedorEmail}</td>
            <td>{$compra->getIdProducto()}</td>
            <td>{$compra->getFechaCompra()}</td>
            <td>{$metodoPago}</td>
        </tr>";
    }

    echo "</table>";

    $contenidoPrincipal = ob_get_clean();
}

require_once __DIR__ . '/../comun/plantilla.php';
