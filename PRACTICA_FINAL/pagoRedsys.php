<?php

require_once("includes/application.php"); // Asegúrate de que la ruta sea correcta
 
// Inicializa la aplicación con los datos de la base de datos
application::getInstance()->init([
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'bd'   => 'brandswap' 
]);

$config = require_once("includes/accionCompra/redsysConfig.php");
require_once("includes/accionCompra/apiRedsys.php");
require_once("includes/compras/compraAppService.php");
require_once("includes/productos/productoAppService.php");


$id_usuario = $_SESSION['id_usuario'] ?? null;
$id_producto = $_GET['id_producto'] ?? null;

if (!$id_usuario || !$id_producto) {
    die("Error: Usuario o producto no especificado.");
}

// Obtener precio real del producto desde la base de datos
$productoService = productoAppService::GetSingleton();
$producto = $productoService->obtenerProductoPorId($id_producto);

if (!$producto) {
    die("Producto no encontrado.");
}

$precio = floatval($producto->getPrecio());
$importe_cents = intval($precio * 100); // En céntimos

// Insertar compra vacía para generar ID de pedido
$compraService = compraAppService::GetSingleton();
$id_compra = $compraService->crearCompraPendiente($id_usuario, $id_producto, $precio, "Tarjeta");

// Configurar Redsys
$redsys = new RedsysAPI();
$clave = $config['clave'];
$fuc = $config['codigo_comercio'];
$terminal = $config['terminal'];
$codigo_moneda = $config['moneda'];

$nombre_comercio = "Mi Tienda Web";
$url_tienda = "http://localhost"; // Cambiar en producción
$urlOK = $url_tienda . "/includes/compras/respuestaPago.php?id_producto=$id_producto";
$urlKO = $url_tienda . "/includes/compras/respuestaPago.php?error=1";

// Parámetros Redsys
$redsys->setParameter("DS_MERCHANT_AMOUNT", $importe_cents);
$redsys->setParameter("DS_MERCHANT_ORDER", str_pad($id_compra, 12, "0", STR_PAD_LEFT));
$redsys->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc); 
$redsys->setParameter("DS_MERCHANT_CURRENCY", $codigo_moneda);
$redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", "0");
$redsys->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$redsys->setParameter("DS_MERCHANT_MERCHANTURL", $urlOK); // También actúa como notificación
$redsys->setParameter("DS_MERCHANT_URLOK", $urlOK);
$redsys->setParameter("DS_MERCHANT_URLKO", $urlKO);

$params = $redsys->createMerchantParameters();
$signature = $redsys->createMerchantSignature($clave);
?>

<form id="form_pago" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
    <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1" />
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>" />
    <input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>" />
</form>

<script>
    document.getElementById('form_pago').submit();
</script>