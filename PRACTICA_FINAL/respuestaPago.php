
<?php
require_once("includes/apiRedsys.php"); 
require_once(__DIR__ . "/../compras/compraAppService.php");

session_start();


$signatureVersion = $_POST["Ds_SignatureVersion"] ?? null;
$merchantParameters = $_POST["Ds_MerchantParameters"] ?? null;
$receivedSignature = $_POST["Ds_Signature"] ?? null;

$redsys = new RedsysAPI();
$params = $redsys->decodeMerchantParameters($merchantParameters);

// Verificar firma
if (!$redsys->checkMerchantSignature($config['clave'], $merchantParameters, $receivedSignature)) {
    die("Firma no válida. Pago no verificado.");
}

// Extraer parámetros
$codigoRespuesta = $params["Ds_Response"];
$pedidoId = $params["Ds_Order"];
$importe = $params["Ds_Amount"] / 100;
$id_usuario = $_SESSION['id_usuario'] ?? null;
$id_producto = $_GET['id_producto'] ?? null;

if (!$id_usuario || !$id_producto) {
    die("Sesión inválida o datos incompletos.");
}

// Código de respuesta 0 a 99 = éxito
if (intval($codigoRespuesta) >= 0 && intval($codigoRespuesta) <= 99) {
    // Registrar la compra
    $compraService = compraAppService::GetSingleton();
    $compraService->insertarCompra($id_usuario, $id_producto, $importe, "Tarjeta", $pedidoId);

    echo "<h2> ¡Gracias por tu compra!</h2>";
    echo "<p>Producto ID: $id_producto</p>";
    echo "<p>Importe pagado: $importe €</p>";
    echo "<p>ID del pedido: $pedidoId</p>";
} else {
    echo "<h2> El pago ha sido rechazado</h2>";
    echo "<p>Código de respuesta: $codigoRespuesta</p>";
}