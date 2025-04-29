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
        <p><label>Edad:</label> <input type="number" name="edad" min="0" max="120" required/></p>
        <p><label>Género:</label>
            <select name="genero" required>
                <option value="">Seleccionar</option>
                <option value="Mujer">Mujer</option>
                <option value="Hombre">Hombre</option>
                <option value="Otro">Otro</option>
            </select>
        </p>
        <p><label>País:</label> 
            <input list="paises" name="pais" required>
            <datalist id="paises">
                <option value="España">
                <option value="Argentina">
                <option value="México">
                <option value="Colombia">
                <option value="Chile">
                <option value="Perú">
                <option value="Uruguay">
                <option value="Venezuela">
                <option value="Estados Unidos">
                <option value="Canadá">
                <option value="Reino Unido">
                <option value="Francia">
                <option value="Alemania">
                <option value="Italia">
                <option value="Portugal">
                <option value="Países Bajos">
                <option value="Suiza">
                <option value="Suecia">
                <option value="Noruega">
                <option value="Japón">
                <option value="China">
                <option value="India">
                <option value="Australia">
                <option value="Nueva Zelanda">
                <option value="Brasil">
                <option value="Sudáfrica">
        </datalist>

        </p>
        <p><label>Teléfono:</label>
            <select name="prefijo" required>
                <option value="+34">+34 (España)</option>
                <option value="+54">+54 (Argentina)</option>
                <option value="+52">+52 (México)</option>
                <option value="+57">+57 (Colombia)</option>
                <option value="+56">+56 (Chile)</option>
                <option value="+51">+51 (Perú)</option>
                <option value="+598">+598 (Uruguay)</option>
                <option value="+58">+58 (Venezuela)</option>
                <option value="+1">+1 (EE.UU / Canadá)</option>
                <option value="+44">+44 (Reino Unido)</option>
                <option value="+33">+33 (Francia)</option>
                <option value="+49">+49 (Alemania)</option>
                <option value="+39">+39 (Italia)</option>
                <option value="+351">+351 (Portugal)</option>
                <option value="+31">+31 (Países Bajos)</option>
                <option value="+41">+41 (Suiza)</option>
                <option value="+46">+46 (Suecia)</option>
                <option value="+47">+47 (Noruega)</option>
                <option value="+81">+81 (Japón)</option>
                <option value="+86">+86 (China)</option>
                <option value="+91">+91 (India)</option>
                <option value="+61">+61 (Australia)</option>
                <option value="+64">+64 (Nueva Zelanda)</option>
                <option value="+55">+55 (Brasil)</option>
                <option value="+27">+27 (Sudáfrica)</option>
            </select>

            <input type="text" name="telefono" maxlength="15" placeholder="Número" required/>
        </p>
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

    // Capturar y validar datos del formulario
    $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
    $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $email = trim($datos['email'] ?? '');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $password = trim($datos['password'] ?? '');
    $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $rePassword = trim($datos['rePassword'] ?? '');
    $rePassword = filter_var($rePassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $edad = isset($datos['edad']) ? intval($datos['edad']) : null;
    $genero = isset($datos['genero']) ? trim($datos['genero']) : null;
    $pais = isset($datos['pais']) ? trim($datos['pais']) : null;
    $prefijo = isset($datos['prefijo']) ? trim($datos['prefijo']) : '';
    $telefono = isset($datos['telefono']) ? trim($datos['telefono']) : '';

$telefonoCompleto = $prefijo . $telefono;


    if (empty($nombreUsuario)) {
        $result[] = "El nombre de usuario no puede estar vacío.";
    }
    if (empty($email)) {
        $result[] = "El email no puede estar vacío.";
    }
    if (empty($password)) {
        $result[] = "El password no puede estar vacío.";
    }
    if ($password !== $rePassword) {
        $result[] = "Las contraseñas no coinciden.";
    }
    if (empty($edad) || $edad <= 0) {
        $result[] = "La edad debe ser un número válido.";
    }
    if (empty($genero)) {
        $result[] = "Debes seleccionar un género.";
    }
    if (empty($pais)) {
        $result[] = "El país no puede estar vacío.";
    }
    if (empty($telefono)) {
        $result[] = "Debes introducir un número de teléfono.";
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
    // Asignar rol automáticamente
    $tipo = 'usuario'; // Rol por defecto

    // Contraseña secreta para asignar rol de admin
    $passwordSecreta = 'admin123'; // Puedes cambiar esta contraseña secreta por cualquier valor

    if ($password === $passwordSecreta) {
        $tipo = 'admin'; // Asignar rol de admin si la contraseña es correcta
    }

    if (count($result) === 0) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Crear DTO con los nuevos datos
            $userDTO = new userDTO(
                0, 
                $nombreUsuario, 
                $email, 
                $hashedPassword, 
                $fotoPerfil,
                $tipo,
                $edad,
                $genero,
                $pais,
                $telefonoCompleto
            );

            $userAppService = userAppService::GetSingleton();
            $createdUserDTO = $userAppService->create($userDTO);

            if (!$createdUserDTO) {
                throw new Exception("Error al registrar el usuario.");
            }

            // Iniciar sesión
            $_SESSION["login"] = true;
            $_SESSION["id_usuario"] = $createdUserDTO->id();
            $_SESSION["nombre"] = $createdUserDTO->nombre();
            $_SESSION["email"] = $createdUserDTO->email();
            $_SESSION["foto_perfil"] = $createdUserDTO->fotoPerfil() ?? "uploads/default-avatar.png";
            $_SESSION["tipo"] = $createdUserDTO->tipo();
            header("Location: index.php");
            exit();

        } catch (Exception $e) {
            $result[] = $e->getMessage();
        }
    }

    return $result;
}

}
?>
