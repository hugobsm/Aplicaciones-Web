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
                    <input type="file" name="imagen" accept="image/*"/>
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
            die("❌ ERROR: El formulario no fue enviado por POST.");
        }

        if (empty($_POST)) {
            die("❌ ERROR: El formulario está vacío.");
        }

        // Capturar datos del formulario
        $nombre = trim($datos['nombre_producto'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $precio = trim($datos['precio'] ?? '');

        if (empty($nombre) || empty($descripcion) || empty($precio)) {
            return ["Todos los campos son obligatorios."];
        }

        // 🔍 Verificando contenido de $_FILES
        error_log("🔍 Verificando contenido de \$_FILES:");
        error_log(print_r($_FILES, true));

        $imagenRuta = "uploads/default-product.png"; // Ruta por defecto

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
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

                error_log("🛠️ Moviendo archivo a: " . $rutaFinal);

                if (move_uploaded_file($imagen['tmp_name'], $rutaFinal)) {
                    $imagenRuta = "uploads/" . $nombreImagen;
                    error_log("✅ Imagen subida correctamente: " . $imagenRuta);
                } else {
                    error_log("❌ Error al mover la imagen. Verificar permisos.");
                    return ["Hubo un problema al subir la imagen."];
                }
            } else {
                error_log("❌ Extensión de imagen no permitida: " . $extension);
                return ["Formato de imagen no permitido."];
            }
        } else {
            error_log("⚠️ No se detectó una imagen, usando imagen por defecto.");
        }

        // Insertar en la base de datos
        $productoService = productoAppService::getInstance();

        $resultado = $productoService->publicarProducto($nombre, $descripcion, $precio, $imagenRuta);

        if ($resultado) {
            error_log("✅ Producto publicado con éxito.");
        } else {
            error_log("❌ Error al publicar el producto en la base de datos.");
            return ["Hubo un error al guardar el producto."];
        }

        // Redirigir a la página correcta
        $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 1);
        header("Location: $base_url/profile.php");
        exit();
    }
}
?>
