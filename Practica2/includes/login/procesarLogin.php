<?php
include __DIR__ . "/../comun/formBase.php";
include __DIR__ . "/../usuario/userAppService.php";

class loginForm extends formBase
{
    public function __construct() 
    {
        parent::__construct('loginForm');
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
            <legend>Usuario y contraseña</legend>
            <p><label>Email:</label> <input type="email" name="nombreUsuario" value="$nombreUsuario" required/></p>
            <p><label>Password:</label> <input type="password" name="password" required/></p>
            <button type="submit" name="login">Entrar</button>
        </fieldset>
EOF;
        return $html;
    }
    
    protected function Process($datos)
    {
        $result = array();

        $email = trim($datos['nombreUsuario'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($email)) 
        {
            $result[] = "El email no puede estar vacío";
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($password)) 
        {
            $result[] = "El password no puede estar vacío.";
        }

        if (count($result) === 0) 
        {
            $userDTO = new userDTO(0, $email, $password);
            $userAppService = userAppService::GetSingleton();

            $foundedUserDTO = $userAppService->login($userDTO);

            if (!$foundedUserDTO) 
            {
                $result[] = "El usuario o la contraseña no coinciden.";
            } 
            else 
            {
                $_SESSION["login"] = true;
                $_SESSION["id_usuario"] = $foundedUserDTO->getId();
                $_SESSION["nombre"] = $foundedUserDTO->getNombre();
                $_SESSION["email"] = $foundedUserDTO->getEmail();
                $_SESSION["foto_perfil"] = $foundedUserDTO->getFotoPerfil() ?? "uploads/default-avatar.png"; 

                $result = 'index.php';
            }
        }
        return $result;
    }
}
?>
