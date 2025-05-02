<?php
session_start();
require_once("includes/accionCompra/apiRedsys.php");
$config = require_once("includes/accionCompra/redsysConfig.php");

// Verifica y guarda el importe
if (!isset($_POST['importe'])) {
    die("No se recibió el importe.");
}

//$importe = floatval($_POST['importe']);
$importe = isset($_POST['importe']) ? str_replace(',', '.', $_POST['importe']) : 0;
if ($importe <= 0) {
    die("Importe no válido.");
}

$_SESSION['importe_recarga'] = $importe;
//$importe_cents = strval(intval(round($importe * 100))); // 💰 céntimos enteros sin separador
$importe_cents = intval(floatval($importe) * 100);
error_log("Importe enviado a Redsys (en céntimos): " . $importe_cents);
error_log("Importe recibido: $importe, convertido a céntimos: $importe_cents");


// Parámetros de configuración
$clave = $config['clave'];
$fuc = $config['codigo_comercio'];
$terminal = $config['terminal'];
$moneda = $config['moneda'];
$trans = $config['trans'];
$pedido = str_pad(strval(mt_rand(1, 99999999)), 12, "0", STR_PAD_LEFT);
$urlOK = $config['url_ok'];
$urlKO = $config['url_ko'];
$urlNotificacion = $config['url_notificacion'];

// Configura RedsysAPI
$redsys = new RedsysAPI();
$redsys->setParameter("DS_MERCHANT_AMOUNT", strval($importe_cents));
$redsys->setParameter("DS_MERCHANT_ORDER", $pedido);
$redsys->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$redsys->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
$redsys->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$redsys->setParameter("DS_MERCHANT_MERCHANTURL", $urlNotificacion);
$redsys->setParameter("DS_MERCHANT_URLOK", $urlOK);
$redsys->setParameter("DS_MERCHANT_URLKO", $urlKO);





// Codifica y firma
$params = $redsys->createMerchantParameters();
$signature = $redsys->createMerchantSignature($clave);

$decodedParams = base64_decode($params);
error_log("MerchantParameters decodificados: " . $redsys->createMerchantParameters());
error_log("Decoded JSON: " . $decodedParams);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Redirigiendo a Redsys...</title>
</head>
<body>
    <p>Redirigiendo al sistema de pagos seguro...</p>
    <form id="form_pago" action="https://sis-t.redsys.es/sis/realizarPago" method="POST">
        <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1" />
        <input type="hidden" name="Ds_MerchantParameters" value="<?php echo htmlspecialchars($params); ?>" />
        <input type="hidden" name="Ds_Signature" value="<?php echo htmlspecialchars($signature); ?>" />
        <input type="submit" value="Pagar manualmente">
    </form>

    <script>
        document.getElementById('form_pago').submit();
    </script>
</body>
</html>
