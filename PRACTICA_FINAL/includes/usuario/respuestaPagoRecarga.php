
<?php
session_start();
require_once("../accionCompra/apiRedsys.php");
$config = require("../accionCompra/redsysConfig.php");
require_once("../../services/userAppService.php");

$redsys = new RedsysAPI();

if (!isset($_POST["Ds_MerchantParameters"])) {
    die("Parámetros incorrectos");
}

$clave = $config["clave"];
$params = $redsys->decodeMerchantParameters($_POST["Ds_MerchantParameters"]);
$signature = $redsys->createMerchantSignatureNotif($clave, $_POST["Ds_MerchantParameters"]);

if ($signature !== $_POST["Ds_Signature"]) {
    die("Firma no válida");
}

$responseCode = (int)$params["Ds_Response"];

if ($responseCode >= 0 && $responseCode <= 99) {
    // PAGO CORRECTO
    if (isset($_SESSION["id_usuario"]) && isset($_SESSION["importe_recarga"])) {
        $id_usuario = $_SESSION["id_usuario"];
        $importe = floatval($_SESSION["importe_recarga"]);

        // Llamada a userAppService para sumar saldo
        $servicio = userAppService::GetSingleton();
        $servicio->sumarSaldo($id_usuario, $importe);

        unset($_SESSION["importe_recarga"]);

        echo "<h2>Recarga completada con éxito</h2>";
        echo "<p>Importe recargado: €" . number_format($importe, 2) . "</p>";
    } else {
        echo "<p>No se pudo procesar la recarga: sesión inválida.</p>";
    }
} else {
    echo "<h2>Recarga fallida</h2>";
    echo "<p>Error en el pago. Código de respuesta: $responseCode</p>";
}
?>