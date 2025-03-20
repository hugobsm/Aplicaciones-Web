<?php
include __DIR__ . "/../../comun/formBase.php";
include __DIR__ . "/../productoAppService.php";

class publicarProductoForm extends formBase {
    public function __construct() {
        parent::__construct('publicarProductoForm');
    }

    protected function CreateFields($datos) {
        $html = <<<EOF
        <fieldset>
            <legend>Publicar Nuevo Producto</legend>
            <p><label>Nombre del Producto:</label> <input type="text" name="nombre_producto" required/></p>
            <p><label>Descripción:</label> <textarea name="descripcion" required></textarea></p>
            <p><label>Precio:</label> <input type="number" name="precio" step="0.01" required/></p>
            <p><label>Imagen del Producto:</label> <input type="file" name="imagen" accept="image/*" required/></p>
            <button type="submit" name="publicar">Publicar</button>
        </fieldset>
EOF;
        return $html;
    }

    protected function Process($datos) {
        session_start();

        if (!isset($_SESSION['id_usuario'])) {
            return ["Debes iniciar sesión para publicar un producto."];
        }

        $id_usuario = $_SESSION['id_usuario'];
        $nombre = trim($datos['nombre_producto'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $precio = trim($datos['precio'] ?? '');

        if (empty($nombre) || empty($descripcion) || empty($precio)) {
            return ["Todos los campos son obligatorios."];
        }

        // Manejo de imagen
        $rutaImagen = "uploads/default-product.png";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $imagen = $_FILES['imagen'];
            $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            if (in_array($extension, $extensionesPermitidas)) {
                if (!is_dir("uploads/")) {
                    mkdir("uploads/", 0777, true);
                }
                $nombreImagen = "uploads/" . uniqid("producto_") . "." . $extension;
                move_uploaded_file($imagen['tmp_name'], $nombreImagen);
                $rutaImagen = $nombreImagen;
            } else {
                return ["Formato de imagen no permitido."];
            }
        }

        // Crear DTO y guardar en BD
        $productoDTO = new ProductoDTO(0, $id_usuario, $nombre, $descripcion, $precio, $rutaImagen, date("Y-m-d H:i:s"));
        $productoAppService = productoAppService::GetSingleton();

        try {
            $productoAppService->crearProducto($productoDTO);
            header("Location: profile.php");
            exit();
        } catch (Exception $e) {
            return [$e->getMessage()];
        }
    }
}
?>
