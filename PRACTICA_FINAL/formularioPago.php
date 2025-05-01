<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Introducir Importe</title>
</head>
<body>
    <h2>Recargar saldo</h2>
    <form action="redirigirARedsys.php" method="post">
        <label for="importe">Importe (€):</label>
        <input type="number" step="0.01" name="importe" id="importe" required><br><br>

        <label for="tarjeta">Número de Tarjeta (simulado):</label>
        <input type="text" name="tarjeta" id="tarjeta" maxlength="16" required><br><br>

        <label for="cvc">CVC (simulado):</label>
        <input type="text" name="cvc" id="cvc" maxlength="4" required><br><br>

        <input type="submit" value="Continuar con el pago">
    </form>
</body>
</html>