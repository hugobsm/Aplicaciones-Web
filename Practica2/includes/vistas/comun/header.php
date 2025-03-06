<?php
//session_start(); // Asegura que se inicie la sesión en cada página que depende de ella
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function mostrarSaludo() 
{
    if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
        echo "<a href='profile.php'>Bienvenido, ". $_SESSION['nombre'] ."</a>. <a href='logout.php'>(Salir)</a>";
    } else {
        echo "<a href='login.php'>Iniciar sesión</a> | <a href='registro.php'>Registro</a>";
    }
}

?>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #fff;
        color: #000;
        padding-top: 80px; /* Evita que el contenido se solape con el header */
    }
    .header {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 40px;
        border-bottom: 1px solid black;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: white;
        z-index: 1000;
        box-sizing: border-box;
    }
    .header-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .left-menu, .right-menu {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .logo {
        text-align: center;
    }
    .logo img {
        height: 80px;
    }
    .left-menu a, .right-menu a {
        text-decoration: none;
        color: #000;
        font-size: 14px;
        text-transform: uppercase;
        position: relative;
    }
    .left-menu a::after, .right-menu a::after {
        content: '';
        display: block;
        width: 0;
        height: 1px;
        background: #000;
        transition: width .3s;
        position: absolute;
        bottom: -5px;
        left: 0;
    }
    .left-menu a:hover::after, .right-menu a:hover::after {
        width: 100%;
    }
    .search input {
        border: 1px solid #ccc;
        padding: 8px 15px;
        font-size: 14px;
        border-radius: 20px;
        outline: none;
    }
    .menu-toggle {
        display: none;
        flex-direction: column;
        cursor: pointer;
    }
    .menu-toggle span {
        height: 3px;
        width: 25px;
        background: black;
        margin: 5px 0;
    }
    @media (max-width: 768px) {
        .header-container {
            flex-direction: row;
            justify-content: space-between;
        }
        .left-menu, .right-menu {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 60px;
            left: 0;
            width: 100%;
            background: white;
            padding: 10px;
            border-top: 1px solid black;
        }
        .left-menu.active, .right-menu.active {
            display: flex;
        }
        .menu-toggle {
            display: flex;
        }
    }
</style>

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
                <a href="about.php">About Us</a>
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
