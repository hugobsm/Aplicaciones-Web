<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $importe = $_SESSION["importe_recarga"] ?? null;

    if ($importe === null) {
        echo "No se encontró el importe en sesión.";
        exit;
    }

    echo "<h2>✅ Pago simulado realizado correctamente</h2>";
    echo "<p>Importe cargado: €" . htmlspecialchars($importe) . "</p>";
} else {
    echo "Acceso no permitido.";
}
