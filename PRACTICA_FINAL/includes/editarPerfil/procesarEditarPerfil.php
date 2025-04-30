<?php
require_once(__DIR__ . "/../comun/formBase.php");
require_once(__DIR__ . "/../usuario/userAppService.php");

class editarPerfilForm extends formBase
{
    public function __construct()
    {
        parent::__construct('editarPerfilForm');
    }

    protected function CreateFields($datos)
{
    $app = Application::getInstance();
    $id_usuario = $_SESSION['id_usuario'] ?? null;

    if (!$id_usuario) {
        return "<p class='error-message'>Debes iniciar sesión para editar tu perfil.</p>";
    }

    $userService = userAppService::GetSingleton();
    $user = $userService->getUserProfile($id_usuario);

    if (!$user) {
        return "<p class='error-message'>Error cargando datos.</p>";
    }

    $nombre = htmlspecialchars($user->nombre());
    $email = htmlspecialchars($user->email());
    $edad = htmlspecialchars($user->edad());
    $genero = htmlspecialchars($user->genero());
    $pais = htmlspecialchars($user->pais());
    $telefono = htmlspecialchars($user->telefono());

    $html = <<<HTML
    <div class="editar-perfil-container">
        <h1>Editar Mi Perfil</h1>
        <form method="POST" class="editar-perfil-form">
            <input type="hidden" name="id_usuario" value="{$id_usuario}">

            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombreUsuario" value="{$nombre}" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{$email}" required>
            </div>

            <div class="form-group">
                <label>Edad:</label>
                <input type="number" name="edad" value="{$edad}" min="0" max="120">
            </div>

            <div class="form-group">
                <label>Género:</label>
                <select name="genero" required>
                    <option value="Mujer" {$this->selected($genero, 'Mujer')}>Mujer</option>
                    <option value="Hombre" {$this->selected($genero, 'Hombre')}>Hombre</option>
                    <option value="Otro" {$this->selected($genero, 'Otro')}>Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label>País:</label>
                <input type="text" name="pais" value="{$pais}" required>
            </div>

            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="{$telefono}">
            </div>

            <button type="submit" name="editar">Guardar Cambios</button>
            <a href="profile.php" class="button-cancelar">Cancelar</a>
        </form>
    </div>
HTML;

    return $html;
}


    protected function selected($valor, $comparacion)
    {
        return ($valor === $comparacion) ? 'selected' : '';
    }

    protected function Process($datos)
    {
        $userService = userAppService::GetSingleton();
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if (!$id_usuario) {
            return "index.php";
        }

        $nombre = trim($datos['nombreUsuario']);
        $email = trim($datos['email']);
        $edad = intval($datos['edad']);
        $genero = trim($datos['genero']);
        $pais = trim($datos['pais']);
        $telefono = trim($datos['telefono']);

        $userService->actualizarPerfil($id_usuario, $nombre, $email, $edad, $genero, $pais, $telefono);

        return "profile.php";
    }
}
?>
