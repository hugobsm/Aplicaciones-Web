<?php 
include __DIR__ . "/../../comun/formBase.php";
include __DIR__ . "/../../productos/productoAppService.php";
require_once __DIR__ . "/../../productos/productoDTO.php";

class publicarProductoForm extends formBase {
    public function __construct() {
        parent::__construct('publicarProductoForm');
    }

    protected function CreateFields($datos) {
        $nombre = $datos['nombre_producto'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $precio = $datos['precio'] ?? '';

        $html = <<<EOF
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
EOF;


        return $html;
    }

    protected function Process($datos) {
       

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ["❌ ERROR: El formulario no fue enviado por POST."];
        }

        $nombre = trim($_POST['nombre_producto'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = floatval($_POST['precio'] ?? 0);
        $nombreArchivo = null;
//$nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $precio = filter_var($precio, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        error_log("🛠️ Procesando publicación de producto: $nombre, $descripcion, $precio");

    // Validación básica
        if (!$nombre || !$descripcion || !$precio) {
            return ["Todos los campos son obligatorios."];
        }
        

        // Procesar la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreOriginal = $_FILES['imagen']['name'];
            $tmpName = $_FILES['imagen']['tmp_name'];
            $ext = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        
            $nombreUnico = uniqid("img_") . "." . $ext;
            $rutaCarpeta = __DIR__ . "/../../../uploads/";
        
            // ✅ Crear la carpeta si no existe
            if (!is_dir($rutaCarpeta)) {
                mkdir($rutaCarpeta, 0777, true);
            }
        
            $rutaDestino = $rutaCarpeta . $nombreUnico;
        
            if (!move_uploaded_file($tmpName, $rutaDestino)) {
                return ["❌ No se pudo mover la imagen al directorio destino."];
            }
        
            $nombreArchivo = "uploads/" . $nombreUnico; // este es el valor que se guarda en la BBDD
        } else {
            return ["❌ Error al subir la imagen."];
        }
        

        $usuario_id = $_SESSION['id_usuario'] ?? 0;
        $fecha_publicacion = date("Y-m-d H:i:s");

        $productoDTO = new ProductoDTO(
            null,
            $usuario_id,
            $nombre,
            $descripcion,
            $precio,
            $nombreArchivo, // <- Solo el nombre del archivo se guarda
            $fecha_publicacion
        );

        $productoService = productoAppService::getInstance();
        $resultado = $productoService->publicarProducto($productoDTO);

        if ($resultado) {
            error_log("✅ Producto guardado correctamente.");
            $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 1);
            header("Location: $base_url/profile.php");
            exit();
        } else {
            return ["Hubo un error al guardar el producto."];
        }
    }
}
?>
