<?php
require_once(__DIR__ . "/../comun/formBase.php");
require_once(__DIR__ . "/../usuario/userAppService.php");
require_once(__DIR__ . "/../compras/compraAppService.php");

class profileForm extends formBase
{
    public function __construct()
    {
        parent::__construct('profileForm');
    }

    protected function CreateFields($datos)
    {
        // Verificar login
        $app = Application::getInstance();
        $id_usuario = $app->getAtributoPeticion("id_usuario") ?? $_SESSION['id_usuario'] ?? null;

        if (!$id_usuario) {
            return "<p>Error: Debes iniciar sesión para ver tu perfil.</p>";
        }

        $userAppService = userAppService::GetSingleton();
        $compraService = compraAppService::GetSingleton();

        $user = $userAppService->getUserProfile($id_usuario);
        if (!$user) {
            return "<p>Error al cargar los datos del usuario.</p>";
        }

        $productos = $userAppService->getUserProducts($id_usuario);
        $mensaje = empty($productos) ? "No has subido ningún producto aún." : "";

        $compras = $compraService->obtenerComprasPorUsuario($id_usuario);

        $nombre = htmlspecialchars($user->nombre(), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($user->email(), ENT_QUOTES, 'UTF-8');
        $foto_perfil = !empty($user->fotoPerfil()) ? htmlspecialchars($user->fotoPerfil(), ENT_QUOTES, 'UTF-8') : "uploads/default-avatar.png";

        $html = <<<HTML
        <div class="perfil-container">
            <h1>Mi Perfil</h1>
            <div class="perfil-info">
                <img class="perfil-foto" src="{$foto_perfil}" alt="Foto de perfil">
                <div class="perfil-datos">
                    <p><strong>Nombre:</strong> {$nombre}</p>
                    <p><strong>Email:</strong> {$email}</p>
                </div>
            </div>

            <div class="publicar-container">
                <a href="publicarProducto.php" class="button publicar-button">Publicar Artículo</a>
            </div>

            <h2>Mis Productos</h2>
            <div class="productos-container">
HTML;

        if ($mensaje) {
            $html .= "<p class='no-products'>{$mensaje}</p>";
        } else {
            foreach ($productos as $producto) {
                $imgTag = str_starts_with($producto['imagen'], 'uploads')
                    ? '<img class="product-image" src="' . $producto['imagen'] . '" alt="Imagen del producto">'
                    : '<img class="product-image" src="data:image/png;base64,' . $producto['imagen'] . '" alt="Imagen del producto">';

                $html .= <<<HTML
                <div class="product-card">
                    $imgTag
                    <div class="product-details">
                        <h3 class="product-name">{$producto['nombre_producto']}</h3>
                        <p class="product-description">{$producto['descripcion']}</p>
                        <p class="product-price"><strong>Precio:</strong> \${$producto['precio']}</p>
                        <p class="product-date"><strong>Publicado:</strong> {$producto['fecha_publicacion']}</p>
                    </div>
                    <div class="product-buttons">
                        <a href="editarproducto.php?id={$producto['id_producto']}" class="button edit-button">Editar</a>
                        <a href="eliminarproducto.php?id={$producto['id_producto']}" class="button delete-button">Eliminar</a>
                    </div>
                </div>
HTML;
            }
        }

        // Mostrar compras
        $html .= <<<HTML
        </div>
        <h2>Mis Compras</h2>
        <div class="productos-container">
HTML;

        if (empty($compras)) {
            $html .= "<p class='no-products'>Aún no has realizado ninguna compra.</p>";
        } else {
            foreach ($compras as $compra) {
                $idProducto = htmlspecialchars($compra->getIdProducto());
                $fechaCompra = htmlspecialchars($compra->getFechaCompra());
                $metodoPago = htmlspecialchars($compra->getMetodoPago());
                $idVendedorRaw = $compra->getIdVendedor();
                $idVendedor = htmlspecialchars($idVendedorRaw);

                $html .= <<<HTML
                <div class="product-card">
                    <div class="product-details">
                        <h3 class="product-name">Producto comprado (ID: $idProducto)</h3>
                        <p class="product-date"><strong>Fecha de compra:</strong> {$fechaCompra}</p>
                        <p class="product-date"><strong>Método de pago:</strong> {$metodoPago}</p>
                        <p class="product-name">ID vendedor: $idVendedorRaw</p>
                        <a href="valorarVendedor.php?id_vendedor=$idVendedorRaw" class="button valorar-button">Valorar vendedor</a>

                    </div>
                </div>
HTML;
            }
        }

        $html .= "</div></div>";
        return $html;
    }

    protected function Process($datos)
    {
        return "profile.php";
    }

    public function compraValorada($id_compra)
    {
        $conn = application::getInstance()->getConexionBd();

        $query = "SELECT COUNT(*) as total FROM valoraciones WHERE id_compra = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_compra);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($fila = $resultado->fetch_assoc()) {
            return $fila['total'] > 0; // Devuelve true si ya está valorada
        }

        return false;
    }
}
