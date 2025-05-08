<?php
session_start();

$status = $_GET['status'] ?? 'ko';
$importe = $_SESSION['importe_recarga'] ?? 'desconocido';

if ($status === 'ok') {
    echo "<h2>✅ Recarga realizada con éxito</h2>";
    echo "<p>Importe recargado: $importe €</p>";

    // Aquí podrías guardar en la base de datos que el usuario recargó saldo
    // y sumarle el importe a su cuenta

} else {
   
}
?>
