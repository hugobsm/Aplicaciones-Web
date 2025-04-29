
<?php
require_once(__DIR__ . "/includes/accionCompra/redsysConfig.php");
require_once(__DIR__ . "/includes/accionCompra/apiRedsys.php"); // SDK oficial de Redsys PHP 


$config = include(__DIR__ . "/includes/accionCompra/redsysConfig.php");

$pedido_id = substr(strval(time()), -12); // un número de 12 dígitos
//$pedido_id = uniqid();
$importe = intval(floatval($_GET['precio']) * 100); // Por ejemplo 12.34 → 1234
//$importe = number_format($_GET['precio'], 2, '', '');
$id_producto = $_GET['id_producto'] ?? '';
$id_usuario = $_GET['id_usuario'] ?? null;

if (!$id_usuario || !$id_producto || !$importe) {
    die("Datos incompletos para el pago.");
}

$miObj = new RedsysAPI();
$miObj->setParameter("DS_MERCHANT_AMOUNT", $importe);
$miObj->setParameter("DS_MERCHANT_ORDER", strval($pedido_id));
$miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $config['codigo_comercio']);
$miObj->setParameter("DS_MERCHANT_CURRENCY", $config['moneda']);
$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", "0");
$miObj->setParameter("DS_MERCHANT_TERMINAL", $config['terminal']);
$miObj->setParameter("DS_MERCHANT_MERCHANTURL", $config['url_notificacion']);
$miObj->setParameter("DS_MERCHANT_URLOK", $config['url_ok'] . "&id_producto=$id_producto");
$miObj->setParameter("DS_MERCHANT_URLKO", $config['url_ko']);
$miObj->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION", "Compra de producto");
$miObj->setParameter("DS_MERCHANT_TITULAR", "Usuario Web");

$params = $miObj->createMerchantParameters();
$signature = $miObj->createMerchantSignature($config['clave']);
?>

<form id="form_redsys" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
    <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1" />
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>" />
    <input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>" />
</form>
<script>
    document.getElementById("form_redsys").submit();
</script> 