<?php

require("userFactory.php");

class userAppService
{
    private static $instance;

    public static function GetSingleton()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct() {}

    public function login($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();
        $foundedUserDTO = $IUserDAO->login($userDTO);
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

    public function actualizarPerfil($id_usuario, $nombre, $email, $edad, $genero, $pais, $telefono)
    {
        $IUserDAO = userFactory::CreateUser();
        return $IUserDAO->actualizarPerfil($id_usuario, $nombre, $email, $edad, $genero, $pais, $telefono);
    }

    public function sumarSaldo($id_usuario, $cantidad)
    {
        $IUserDAO = userFactory::CreateUser();
        return $IUserDAO->sumarSaldo($id_usuario, $cantidad);
    }

    public function restarSaldo($id_usuario, $cantidad)
    {
        $IUserDAO = userFactory::CreateUser();
        return $IUserDAO->restarSaldo($id_usuario, $cantidad);
    }

    public function eliminarProducto($idProducto)
    {
        $productoDAO = ProductoDAO::getInstance();
        return $productoDAO->borrarPorId($idProducto);
    }

    public function getProductoPorId($idProducto)
    {
        $productoDAO = ProductoDAO::getInstance();
        return $productoDAO->obtenerPorId($idProducto);
    }

    // NUEVO MÉTODO SIN DAO NI TABLA EXTRA
    public function procesarRecargaDesdeSesion()
    {
        if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['importe_pendiente'])) {
            return false;
        }

        $id_usuario = $_SESSION['id_usuario'];
        $importe = floatval($_SESSION['importe_pendiente']);

        if ($importe <= 0) {
            return false;
        }

        $this->sumarSaldo($id_usuario, $importe);
        unset($_SESSION['importe_pendiente']); // Limpieza por seguridad

        return true;
    }

    public function getUserById($idUsuario) {
        $IUserDAO = userFactory::CreateUser();
        return $IUserDAO->getUserById($idUsuario);
    }
    
    
}
?>