<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Sitio Web</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            border-bottom: 1px solid black;
        }
        .left-menu, .right-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .logo {
            flex-grow: 1;
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
            border: 1px solid #e5e5e5;
            padding: 5px 10px;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            .left-menu, .right-menu {
                display: none;
                flex-direction: column;
                width: 100%;
                background: #fff;
                position: absolute;
                top: 60px;
                left: 0;
                border-top: 1px solid #e5e5e5;
            }
            .left-menu.active, .right-menu.active {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <header class="header">
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
            <?= $authLink ?>
        </div>
    </header>
</body>
</html>
