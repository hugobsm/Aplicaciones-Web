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
    <div class="login-container">
        <h1>Usuario y Contraseña</h1>
        <form method="POST" class="login-form">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="nombreUsuario" value="{$nombreUsuario}" required/>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required/>
            </div>

            <button type="submit" name="login">Entrar</button>
        </form>
    </div>
EOF;

        return $html;
    }
    protected function Process($datos)
{
    

    $email = trim($datos['nombreUsuario'] ?? '');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    

    $password = trim($datos['password'] ?? '');
    $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($email) || empty($password)) {
        
        return ["El email y la contraseña no pueden estar vacíos."];
    }

    $userDTO = new userDTO(0, "", $email, $password);
    $userAppService = userAppService::GetSingleton();
    $foundedUserDTO = $userAppService->login($userDTO);

    if (!$foundedUserDTO) {
        
        return ["El usuario o la contraseña no coinciden."];
    } 

   

    $_SESSION["login"] = true;
$_SESSION["id_usuario"] = $foundedUserDTO->id();
$_SESSION["nombre"] = $foundedUserDTO->nombre();
$_SESSION["email"] = $foundedUserDTO->email();
$_SESSION["foto_perfil"] = $foundedUserDTO->fotoPerfil() ?? "uploads/default-avatar.png";
$_SESSION["tipo"] = $foundedUserDTO->tipo();



    header("Location: index.php");
    exit();
}

}
?>
