<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Conexión a la base de datos
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "brandswap";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los productos del usuario
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM productos WHERE id_usuario = ? ORDER BY fecha_publicacion DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si el usuario tiene productos subidos
if ($result->num_rows == 0) {
    $mensaje = "No has subido ningún producto aún.";
} else {
    $productos = $result->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 70%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product {
            border-bottom: 1px solid #ccc;
            padding: 15px 0;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        .product-info {
            flex-grow: 1;
            margin-left: 20px;
        }
        .product-name {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .product-price {
            color: green;
            font-size: 1rem;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .button {
            background-color: black;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: gray;
        }
        .no-products {
            font-size: 1.2rem;
            color: gray;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Mis Productos</h1>
    
    <?php if (isset($mensaje)) { ?>
        <p class="no-products"><?php echo $mensaje; ?></p>
    <?php } else { ?>
        <?php foreach ($productos as $producto) { ?>
            <div class="product">
                <img src="uploads/<?php echo $producto['imagen']; ?>" alt="Imagen del producto">
                <div class="product-info">
                    <p class="product-name"><?php echo htmlspecialchars($producto['nombre_producto']); ?></p>
                    <p class="product-price"><?php echo "$" . number_format($producto['precio'], 2); ?></p>
                </div>
                <div class="buttons">
                    <a href="editarproducto.php?id=<?php echo $producto['id_producto']; ?>" class="button">Editar</a>
                    <a href="eliminarproducto.php?id=<?php echo $producto['id_producto']; ?>" class="button">Eliminar</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
