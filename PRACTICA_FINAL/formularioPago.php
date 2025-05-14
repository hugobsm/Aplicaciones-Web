<?php

require_once("includes/config.php");
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

    <form id="pagoForm" action="includes/accionCompra/redirigirARedsys.php" method="post" onsubmit="return validarFormulario()">
        <label for="importe">Importe (€):</label>
        <input type="number" step="0.01" name="importe" id="importe" required><br>
        <span id="errorImporte" class="error"></span><br>

        <input type="submit" value="Continuar con el recargo de saldo">
    </form>

    <script>
        function validarFormulario() {
            let valido = true;

            // Limpiar mensajes anteriores
            document.getElementById('errorImporte').textContent = '';

            // Validación del importe
            const importe = parseFloat(document.getElementById('importe').value);
            if (isNaN(importe) || importe <= 0) {
                document.getElementById('errorImporte').textContent = 'El importe debe ser mayor que 0.';
                valido = false;
            }

            return valido;
        }
    </script>
</body>
</html>
