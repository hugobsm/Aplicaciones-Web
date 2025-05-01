<?php

require_once("includes/accionCompra/apiRedsys.php");
$config = require_once("includes/accionCompra/redsysConfig.php");


// ✅ VALIDACIÓN DEL IMPORTE
if (isset($_POST['importe'])) {
    $importe = floatval($_POST['importe']);

    if ($importe <= 0) {
        die("Importe no válido.");
    }

    $_SESSION['importe_recarga'] = $importe;

    // 💡 Aquí debes convertirlo a céntimos
    $importe_cents = number_format($importe * 100, 0, '', '');

    } else {
        die("No se recibió el importe.");
    }

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
$redsys->setParameter("DS_MERCHANT_AMOUNT", $importe_cents);
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



// Solo para debug: inspeccionar los datos enviados
echo "<pre>";
echo "🧾 Datos enviados a Redsys:\n";
print_r($redsys->decodeMerchantParameters($params));
echo "\n🔐 Firma generada:\n";
echo $signature;
echo "</pre>";
exit;

 
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
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo htmlspecialchars($params); ?>" />
    <input type="hidden" name="Ds_Signature" value="<?php echo htmlspecialchars($signature); ?>" />
</form>
    <script>
        document.getElementById('form_pago').submit();
    </script>
</body>
</html>