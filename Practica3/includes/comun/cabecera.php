<?php
function mostrarSaludo() 
{
    if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
        echo "<a href='profile.php'>Bienvenido, ". $_SESSION['nombre'] ."</a>. <a href='logout.php'>(Salir)</a>";
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
                <a href="checkout.php">Compra</a>
                <a href="miembros.php">About Us</a>
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
