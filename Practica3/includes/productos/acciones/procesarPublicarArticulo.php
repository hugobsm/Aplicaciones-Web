<?php
include __DIR__ . "/../../comun/formBase.php";
include __DIR__ . "/../../productos/productoAppService.php";

class publicarProductoForm extends formBase {
    public function __construct() {
        parent::__construct('publicarProductoForm');
    }

    protected function CreateFields($datos) {
        $nombre = $datos['nombre_producto'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $precio = $datos['precio'] ?? '';

        $html = <<<EOF
        <form method="POST" action="{$_SERVER['PHP_SELF']}" enctype="multipart/form-data">
            <fieldset>
                <legend>Publicar Nuevo Producto</legend>

                <p><label>Nombre del Producto:</label> 
                    <input type="text" name="nombre_producto" value="$nombre" required/>
                </p>

                <p><label>Descripción:</label> 
                    <textarea name="descripcion" required>$descripcion</textarea>
                </p>

                <p><label>Precio:</label> 
                    <input type="number" name="precio" value="$precio" required/>
                </p>

                <p><label>Imagen del Producto:</label> 
                    <input type="file" name="imagen" accept="image/*" required/>
                </p>

                <button type="submit" name="publicar">Publicar Producto</button>
            </fieldset>
        </form>
        EOF;

        return $html;
    }

    protected function Process($datos) {
        error_log("🛠️ Entrando en Process() de publicarProductoForm...");

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ["❌ ERROR: El formulario no fue enviado por POST."];
        }

        $nombre = trim($datos['nombre_producto'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $precio = trim($datos['precio'] ?? '');

        if (empty($nombre) || empty($descripcion) || empty($precio)) {
            return ["❌ Todos los campos son obligatorios."];
        }

        $imagenRuta = "uploads/default-product.png"; // Ruta por defecto

        if (isset($_FILES['imagen'])) {
    error_log("🧪 Nombre de la imagen: " . $_FILES['imagen']['name']);
    error_log("🧪 Código de error de imagen: " . $_FILES['imagen']['error']);
}

        if (!empty($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $imagen = $_FILES['imagen'];
            $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            if (in_array($extension, $extensionesPermitidas)) {
                $uploadsDir = __DIR__ . "/../../uploads/";

                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0777, true);
                }

                $nombreImagen = uniqid("producto_") . "." . $extension;
                $rutaFinal = $uploadsDir . $nombreImagen;

                if (move_uploaded_file($imagen['tmp_name'], $rutaFinal)) {
                    $imagenRuta = "uploads/" . $nombreImagen;
                    error_log("✅ Imagen subida correctamente: " . $imagenRuta);
                } else {
                    return ["❌ Hubo un error al mover la imagen. Verifica permisos."];
                }
            } else {
                return ["❌ Formato de imagen no permitido."];
            }
        } else {
            return ["❌ No se ha subido ninguna imagen."];
        }

        // Obtener instancia del servicio
        $productoService = productoAppService::getInstance();
        $resultado = $productoService->publicarProducto($nombre, $descripcion, $precio, $imagenRuta);

        if ($resultado) {
            error_log("✅ Producto publicado con éxito.");
            $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 1);
            header("Location: $base_url/profile.php");
            exit();
        } else {
            error_log("❌ Fallo en productoService->publicarProducto()");
            return ["❌ Ha habido un error al guardar el producto. Inténtalo de nuevo."];
        }
    }
}
?>
