<?php
function mostrarSaludo() 
{
    // Usamos RUTA_APP para construir las rutas absolutas de los enlaces
    if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
        echo "<a href='" . RUTA_APP . "profile.php'>Bienvenido, ". $_SESSION['nombre'] ."</a>. <a href='" . RUTA_APP . "logout.php'>(Salir)</a>";
    } else {
        echo "<a href='" . RUTA_APP . "login.php'>Iniciar sesión</a> | <a href='" . RUTA_APP . "registro.php'>Registro</a>";
    }
}


?>

<body>
    <header class="header">
        <div class="header-container">
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="left-menu">
                <a href="<?php echo RUTA_APP; ?>index.php">Inicio</a>
                <a href="<?php echo RUTA_APP; ?>verProductos.php">Compra</a>
                <a href="<?php echo RUTA_APP; ?>miembros.php">About Us</a>
            </div>
            <div class="logo">
                <a href="<?php echo RUTA_APP; ?>index.php">
                <img src="<?php echo RUTA_APP; ?>Imagenes Marca/logo.png" alt="Logo">
            </div>
            <div class="right-menu">
                <div class="search">
                    <input type="text" placeholder="Buscar...">
                </div>
                <div class="saludo">
                    <?php mostrarSaludo(); ?>
                </div>
            </div>
        </div>
    </header>

    <script>
        function toggleMenu() {
            document.querySelector('.left-menu').classList.toggle('active');
            document.querySelector('.right-menu').classList.toggle('active');
        }
    </script>
</body>
</html>
