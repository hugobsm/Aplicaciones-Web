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
<fieldset>
    <legend>Categorías del producto</legend>
    <div class="form-categorias">
        <div class="cat-bloque">
            <h4>Género</h4>
            <label><input type="checkbox" name="categorias[]" value="Mujer"> Mujer</label>
            <label><input type="checkbox" name="categorias[]" value="Hombre"> Hombre</label>
            <label><input type="checkbox" name="categorias[]" value="Unisex"> Unisex</label>
            <label><input type="checkbox" name="categorias[]" value="Niño"> Niño</label>
        </div>
        <div class="cat-bloque">
            <h4>Tipo</h4>
            <label><input type="checkbox" name="categorias[]" value="Camisetas"> Camisetas</label>
            <label><input type="checkbox" name="categorias[]" value="Sudaderas"> Sudaderas</label>
            <label><input type="checkbox" name="categorias[]" value="Pantalones"> Pantalones</label>
            <label><input type="checkbox" name="categorias[]" value="Vestidos"> Vestidos</label>
            <label><input type="checkbox" name="categorias[]" value="Blusas"> Blusas</label>
            <label><input type="checkbox" name="categorias[]" value="Abrigos"> Abrigos</label>
            <label><input type="checkbox" name="categorias[]" value="Tops"> Tops</label>
            <label><input type="checkbox" name="categorias[]" value="Accesorios"> Accesorios</label>
            <label><input type="checkbox" name="categorias[]" value="Calzado"> Calzado</label>
        </div>
        <div class="cat-bloque">
            <h4>Color</h4>
            <label><input type="checkbox" name="categorias[]" value="Color Verde"> Verde</label>
            <label><input type="checkbox" name="categorias[]" value="Color Azul"> Azul</label>
            <label><input type="checkbox" name="categorias[]" value="Color Rosa"> Rosa</label>
            <label><input type="checkbox" name="categorias[]" value="Color Negro"> Negro</label>
            <label><input type="checkbox" name="categorias[]" value="Color Amarillo"> Amarillo</label>
            <label><input type="checkbox" name="categorias[]" value="Color Naranja"> Naranja</label>
            <label><input type="checkbox" name="categorias[]" value="Color Rojo"> Rojo</label>
            <label><input type="checkbox" name="categorias[]" value="Color Morado"> Morado</label>
            <label><input type="checkbox" name="categorias[]" value="Color Lila"> Lila</label>
            <label><input type="checkbox" name="categorias[]" value="Color Marrón"> Marrón</label>
            <label><input type="checkbox" name="categorias[]" value="Color Blanco"> Blanco</label>
        </div>
        <div class="cat-bloque">
            <h4>Talla</h4>
            <label><input type="checkbox" name="categorias[]" value="Talla XS"> XS</label>
            <label><input type="checkbox" name="categorias[]" value="Talla S"> S</label>
            <label><input type="checkbox" name="categorias[]" value="Talla M"> M</label>
            <label><input type="checkbox" name="categorias[]" value="Talla L"> L</label>
            <label><input type="checkbox" name="categorias[]" value="Talla XL"> XL</label>
        </div>
    </div>
</fieldset>

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
    
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $precio = filter_var($precio, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
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
    
            if (!is_dir($rutaCarpeta)) {
                mkdir($rutaCarpeta, 0777, true);
            }
    
            $rutaDestino = $rutaCarpeta . $nombreUnico;
    
            if (!move_uploaded_file($tmpName, $rutaDestino)) {
                return ["❌ No se pudo mover la imagen al directorio destino."];
            }
    
            $nombreArchivo = "uploads/" . $nombreUnico;
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
            $nombreArchivo,
            $fecha_publicacion
        );
    
        // 🔁 Primero guardar el producto
        $productoService = productoAppService::getInstance();
        $resultado = $productoService->publicarProducto($productoDTO);
    
        // ✅ Si se guarda bien, ahora guardamos categorías
        if ($resultado) {
            $productoId = $resultado->getId(); // Ahora sí: $resultado existe
            $categoriasSeleccionadas = $_POST['categorias'] ?? [];
    
            if (!empty($categoriasSeleccionadas)) {
                $conn = application::getInstance()->getConexionBd();
    
                foreach ($categoriasSeleccionadas as $nombreCategoria) {
                    $query = "SELECT id_categoria FROM categorias WHERE nombre_categoria = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $nombreCategoria);
                    $stmt->execute();
                    $stmt->bind_result($idCategoria);
    
                    if ($stmt->fetch()) {
                        $stmt->close();
                        $insert = $conn->prepare("INSERT INTO producto_categoria (id_producto, id_categoria) VALUES (?, ?)");
                        $insert->bind_param("ii", $productoId, $idCategoria);
                        $insert->execute();
                        $insert->close();
                    } else {
                        $stmt->close();
                        error_log("❌ Categoría '$nombreCategoria' no encontrada en la base de datos.");
                    }
                }
            }
    
            // Redirigir al perfil
            $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 1);
            header("Location: $base_url/profile.php");
            exit();
        } else {
            return ["Hubo un error al guardar el producto."];
        }
    }
    
}
?>
