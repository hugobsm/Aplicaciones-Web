<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Introducir Importe</title>
    <style>
        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h2>Recargar saldo</h2>

    <form id="pagoForm" action="redirigirARedsys.php" method="post" onsubmit="return validarFormulario()">
        <label for="importe">Importe (€):</label>
        <input type="number" step="0.01" name="importe" id="importe" required><br>
        <span id="errorImporte" class="error"></span><br>

        <input type="submit" value="Continuar con el pago">
    </form>

    <script>
        function validarFormulario() {
            let valido = true;

            // Limpiar mensajes anteriores
            document.getElementById('errorImporte').textContent = '';
            document.getElementById('errorTarjeta').textContent = '';
            document.getElementById('errorCVC').textContent = '';

            // Validación del importe
            const importe = parseFloat(document.getElementById('importe').value);
            if (isNaN(importe) || importe <= 0) {
                document.getElementById('errorImporte').textContent = 'El importe debe ser mayor que 0.';
                valido = false;
            }

            // Validación del número de tarjeta
            const tarjeta = document.getElementById('tarjeta').value.trim();
            const tarjetaRegex = /^\d{4} \d{4} \d{4} \d{4}$/;
            if (!tarjetaRegex.test(tarjeta)) {
                document.getElementById('errorTarjeta').textContent = 'La tarjeta debe tener 16 dígitos separados en 4 grupos de 4 (ej. 1234 5678 9012 3456).';
                valido = false;
            }

            // Validación del CVC
            const cvc = document.getElementById('cvc').value.trim();
            const cvcRegex = /^\d{3}$/;
            if (!cvcRegex.test(cvc)) {
                document.getElementById('errorCVC').textContent = 'El CVC debe tener exactamente 3 números.';
                valido = false;
            }

            return valido;
        }
    </script>
</body>
</html>