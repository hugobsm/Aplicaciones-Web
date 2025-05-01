<?php
session_start();
require_once("includes/accionCompra/apiRedsys.php");
$config = require_once("includes/accionCompra/redsysConfig.php");

// ✅ VALIDACIÓN DEL IMPORTE
if (!isset($_POST['importe'])) {
    die("No se recibió el importe.");
}

$importe = floatval($_POST['importe']);
if ($importe <= 0) {
    die("Importe no válido.");
}

// 🔐 GUARDAR EN SESIÓN PARA USO POSTERIOR
$_SESSION['importe_pendiente'] = $importe;

// Redsys trabaja en céntimos
$importeCents = intval($importe * 100);

// 🔧 PARÁMETROS CONFIGURADOS
$clave = $config['clave'];
$fuc = $config['codigo_comercio'];
$terminal = $config['terminal'];
$moneda = $config['moneda'];
$trans = $config['trans'];

$pedido = str_pad(rand(1, 99999999), 12, "0", STR_PAD_LEFT);
$urlOK = $config['url_ok'];
$urlKO = $config['url_ko'];
$urlNotificacion = $config['url_notificacion'];

// 🧠 INICIALIZAR API Redsys
$redsys = new RedsysAPI();
$redsys->setParameter("DS_MERCHANT_AMOUNT", $importeCents);
$redsys->setParameter("DS_MERCHANT_ORDER", $pedido);
$redsys->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$redsys->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
$redsys->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$redsys->setParameter("DS_MERCHANT_MERCHANTURL", $urlNotificacion);
$redsys->setParameter("DS_MERCHANT_URLOK", $urlOK);
$redsys->setParameter("DS_MERCHANT_URLKO", $urlKO);

$params = $redsys->createMerchantParameters();
$signature = $redsys->createMerchantSignature($clave);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Redirigiendo a Redsys...</title>
</head>
<body>
    <p>Redirigiendo al sistema de pagos seguro...</p>
    <form id="form_pago" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
        <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1" />
        <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>" />
        <input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>" />
    </form>
    <script>
        document.getElementById('form_pago').submit();
    </script>
</body>
</html>