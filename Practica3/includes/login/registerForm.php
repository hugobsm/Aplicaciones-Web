<?php
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../usuario/userAppService.php";

class registerForm extends formBase
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombreUsuario = '';

        if ($datos) {
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
        error_log("🛠️ Iniciando Process() en registerForm");

        $result = array();

        // Capturar y validar datos del formulario
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        error_log("📛 Nombre: " . $nombreUsuario);

        if (empty($nombreUsuario)) {
            $result[] = "El nombre de usuario no puede estar vacío.";
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        error_log("📧 Email: " . $email);

        if (empty($email)) {
            $result[] = "El email no puede estar vacío.";
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        error_log("🔑 Contraseña recibida.");

        if (empty($password)) {
            $result[] = "El password no puede estar vacío.";
        }

        $rePassword = trim($datos['rePassword'] ?? '');
        $rePassword = filter_var($rePassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($password !== $rePassword) {
            
            $result[] = "Las contraseñas no coinciden.";
        }

        // Manejo de foto de perfil
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
               
            } else {
                
                $result[] = "Formato de imagen no permitido.";
            }
        }

        if (count($result) === 0) {
            try {
                // Crear DTO correctamente
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $userDTO = new userDTO(0, $nombreUsuario, $email, $hashedPassword, $fotoPerfil);
                $userAppService = userAppService::GetSingleton();

                error_log("🛠️ Creando usuario en la base de datos...");
                $createdUserDTO = $userAppService->create($userDTO);

                if (!$createdUserDTO) {
                    throw new Exception("Error al registrar el usuario.");
                }

                error_log("✅ Usuario registrado correctamente: " . $createdUserDTO->email());

                // Iniciar sesión después del registro
                $_SESSION["login"] = true;
                $_SESSION["id_usuario"] = $createdUserDTO->id();
                $_SESSION["nombre"] = $createdUserDTO->nombre();
                $_SESSION["email"] = $createdUserDTO->email();
                $_SESSION["foto_perfil"] = $createdUserDTO->fotoPerfil() ?? "uploads/default-avatar.png";

                // Redirigir a index.php
                error_log("🔄 Redirigiendo a index.php...");
                header("Location: index.php");
                exit();

            } catch (Exception $e) {
                error_log("❌ Error en el registro: " . $e->getMessage());
                $result[] = $e->getMessage();
            }
        }

        return $result;
    }
}
?>
