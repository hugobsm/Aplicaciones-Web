
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $importe = $_POST["importe"];
    $tarjeta = $_POST["tarjeta"];
    $cvc = $_POST["cvc"];

    // Simulación del pago
    echo "<h2>Pago simulado realizado correctamente</h2>";
    echo "<p>Importe cargado: €" . htmlspecialchars($importe) . "</p>";
    echo "<p>Tarjeta terminada en: ****" . substr($tarjeta, -4) . "</p>";
} else {
    echo "Acceso no permitido.";
}
?>
