<?php

require("userFactory.php");

class userAppService
{
    private static $instance;

    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
  
    private function __construct()
    {
    } 

    public function login($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $foundedUserDTO = $IUserDAO->login($userDTO);

    return $foundedUserDTO;
        return $foundedUserDTO;
    }

    public function create($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $createdUserDTO = $IUserDAO->create($userDTO);

        return $createdUserDTO;
    }
    public function getUserProducts($id_usuario)
    {
        $IUserDAO = userFactory::CreateUser();
        return $IUserDAO->getProductsByUserId($id_usuario);
    }
    public function getUserProfile($id_usuario)
{
    $IUserDAO = userFactory::CreateUser();
    $user = $IUserDAO->getUserById($id_usuario);

    if (!$user) {
        error_log("❌ Error en userAppService: No se encontró el usuario con ID $id_usuario");
    } else {
        error_log("✅ userAppService encontró el usuario: " . $user->nombre());
    }

    return $user;
}



}

?>