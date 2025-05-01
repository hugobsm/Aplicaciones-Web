<?php
session_start();
require_once("includes/accionCompra/apiRedsys.php");
$config = require_once("includes/accionCompra/redsysConfig.php");

$importe = isset($_POST['importe']) ? floatval($_POST['importe']) : 0;
$importe_cents = intval($importe * 100);

// Valores de Redsys desde config
$clave = $config['clave'];
$fuc = $config['codigo_comercio'];
$terminal = $config['terminal'];
$moneda = $config['moneda'];

$pedido = str_pad(rand(1, 99999999), 12, "0", STR_PAD_LEFT);
$url_tienda = "http://localhost"; // ajusta si estás en producción

$urlOK = $url_tienda . "/includes/compras/respuestaPago.php";
$urlKO = $url_tienda . "/includes/compras/respuestaPago.php?error=1";

// Inicializar Redsys
$redsys = new RedsysAPI();
$redsys->setParameter("DS_MERCHANT_AMOUNT", $importe_cents);
$redsys->setParameter("DS_MERCHANT_ORDER", $pedido);
$redsys->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$redsys->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", "0");
$redsys->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$redsys->setParameter("DS_MERCHANT_MERCHANTURL", $urlOK); // notificación
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