<?php
session_start();
include 'includes/accionCompra/apiRedsys.php';

$miObj = new RedsysAPI;

$fuc="999008881";
$terminal="1";
$moneda="978";
$trans="0";
$url="";
$urlOK = 'http://localhost/Aplicaciones-Web/PRACTICA_FINAL/includes/compras/respuestaPagoRecarga.php?status=ok';
$urlKO = 'http://localhost/Aplicaciones-Web/PRACTICA_FINAL/includes/compras/respuestaPagoRecarga.php?status=ko';

$id = time();
$importe = isset($_POST['importe']) ? str_replace(',', '.', $_POST['importe']) : 0;
if ($importe <= 0) {
    die("Importe no válido.");
}

$_SESSION['importe_recarga'] = $importe;
$amount = intval(floatval($importe) * 100);

$miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);
$miObj->setParameter("DS_MERCHANT_ORDER", $id);
$miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$miObj->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
$miObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$miObj->setParameter("DS_MERCHANT_MERCHANTURL", $url);
$miObj->setParameter("DS_MERCHANT_URLOK", $urlOK);
$miObj->setParameter("DS_MERCHANT_URLKO", $urlKO);

$version = "HMAC_SHA256_V1";
$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';
$params = $miObj->createMerchantParameters();
$signature = $miObj->createMerchantSignature($kc);
?>

<!-- El TPV se abrirá en la misma pestaña -->
<form id="form-redsys" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
    <input type="hidden" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/>
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/>
    <input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>"/>
</form>

<script>
    document.getElementById('form-redsys').submit();
</script>
