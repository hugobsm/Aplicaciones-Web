<?php
include __DIR__ . "/../includes/comun/formBase.php";
include __DIR__ . "/../includes/usuario/userAppService.php";

class registerForm extends formBase
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombreUsuario = '';
        
        if ($datos) 
        {
            $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : $nombreUsuario;
        }

        $html = <<<EOF
        <fieldset>
            <legend>Registro de Usuario</legend>
            <p><label>Nombre:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario" required/></p>
            <p><label>Email:</label> <input type="email" name="email" required/></p>
            <p><label>Password:</label> <input type="password" name="password" required/></p>
            <p><label>Re-Password:</label> <input type="password" name="rePassword" required/></p>
            <p><label>Foto de Perfil:</label> <input type="file" name="fotoPerfil" accept="image/*"/></p>
            <button type="submit" name="register">Registrar</button>
        </fieldset>
EOF;
        return $html;
    }

    protected function Process($datos)
    {
        $result = array();

        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($nombreUsuario)) 
        {
            $result[] = "El nombre de usuario no puede estar vacío.";
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($email)) 
        {
            $result[] = "El email no puede estar vacío.";
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($password)) 
        {
            $result[] = "El password no puede estar vacío.";
        }

        $rePassword = trim($datos['rePassword'] ?? '');
        $rePassword = filter_var($rePassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($password !== $rePassword)
        {
            $result[] = "Las contraseñas no coinciden.";
        }

        $fotoPerfil = "uploads/default-avatar.png"; // Imagen por defecto

        if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] == 0) {
            $imagen = $_FILES['fotoPerfil'];
            $extensionesPermitidas = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            if (in_array($extension, $extensionesPermitidas)) {
                if (!is_dir("uploads/")) {
                    mkdir("uploads/", 0777, true);
                }
                $nombreImagen = "uploads/" . uniqid("perfil_") . "." . $extension;
                move_uploaded_file($imagen['tmp_name'], $nombreImagen);
                $fotoPerfil = $nombreImagen;
            }
        }

        if (count($result) === 0) 
        {
            try
            {
                $userDTO = new userDTO(0, $nombreUsuario, $email, password_hash($password, PASSWORD_DEFAULT), $fotoPerfil);
                $userAppService = userAppService::GetSingleton();

                $createdUserDTO = $userAppService->register($userDTO);

                $_SESSION["login"] = true;
                $_SESSION["nombre"] = $nombreUsuario;
                $_SESSION["email"] = $email;
                $_SESSION["foto_perfil"] = $fotoPerfil;

                $result = 'index.php';

                $app = application::getInstance();
                $mensaje = "Registro exitoso. Bienvenido, {$nombreUsuario}!";
                $app->putAtributoPeticion('mensaje', $mensaje);
            }
            catch(userAlreadyExistException $e)
            {
                $result[] = $e->getMessage();
            }
        }

