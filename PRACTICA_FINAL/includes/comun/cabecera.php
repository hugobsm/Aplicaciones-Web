<?php
function mostrarSaludo() 
{
    if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
        // Verifica que $_SESSION['usuario'] esté definida antes de acceder a ella
        if (isset($_SESSION['nombre'])) {
            echo "<a href='profile.php'>Bienvenido, ". htmlspecialchars($_SESSION['nombre']) ."</a>. <a href='logout.php'>(Salir)</a>";
        }
         else {
            echo "<a href='login.php'>Iniciar sesión</a> | <a href='registro.php'>Registro</a>";
        }
    } else {
        echo "<a href='login.php'>Iniciar sesión</a> | <a href='registro.php'>Registro</a>";
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
                <a href="index.php">Inicio</a>
                <a href="verProductos.php">Compra</a>
                <a href="miembros.php">About Us</a>
                <?php
                // Solo el administrador ve esta opción
                if (isset($_SESSION["login"]) && $_SESSION["login"] === true && isset($_SESSION["usuario"]["tipo"]) && $_SESSION["usuario"]["tipo"] === "admin") {
                    echo '<a href="includes/admin/verUsuario.php">Usuarios</a>';
                }
                ?>
            </div>

            <div class="logo">
                <a href="index.php"><img src="Imagenes Marca/logo.png" alt="Logo"></a>
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
