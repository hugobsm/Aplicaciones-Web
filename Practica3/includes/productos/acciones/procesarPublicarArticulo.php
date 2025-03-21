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
                <input type="hidden" name="action" value="publicarProductoForm" />
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
    
        // Datos del formulario
        $nombre = trim($_POST['nombre_producto'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = floatval($_POST['precio'] ?? 0);
        $imagenBase64 = null;
    
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
            if ($contenidoImagen !== false) {
                $imagenBase64 = base64_encode($contenidoImagen);
                error_log("✅ Imagen convertida a base64. Longitud: " . strlen($imagenBase64));
            } else {
                error_log("❌ No se pudo leer el contenido de la imagen.");
            }
        } else {
            error_log("⚠️ No se subió ninguna imagen.");
        }
    
        // Crear DTO
        require_once(__DIR__ . "/../productoDTO.php");
        $usuario_id = $_SESSION['id_usuario'] ?? 0;
        $fecha_publicacion = date("Y-m-d H:i:s");
    
        $productoDTO = new ProductoDTO(
            null,
            $usuario_id,
            $nombre,
            $descripcion,
            $precio,
            $imagenBase64,
            $fecha_publicacion
        );
    
        error_log("📦 ProductoDTO creado");
    
        // Insertar
        $productoService = productoAppService::getInstance();
        $resultado = $productoService->publicarProducto($productoDTO);
    
        if ($resultado) {
            error_log("✅ Producto guardado correctamente.");
            // Redirige
            $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 1);
            header("Location: $base_url/profile.php");
            exit();
        } else {
            error_log("❌ Error al guardar en la base de datos.");
            return ["Hubo un error al guardar el producto."];
        }
    }
    
}

?>
