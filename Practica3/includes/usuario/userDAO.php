<?php

require("IUser.php");
require("userDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");
require("userAlreadyExistException.php");

class userDAO extends baseDAO implements IUser
{
    public function __construct()
    {
    }

    public function login($userDTO)
    {
        error_log("Intentando login con email: " . $userDTO->email());

        $foundedUserDTO = $this->buscaUsuario($userDTO->email());

        if ($foundedUserDTO && self::testHashPassword($userDTO->password(), $foundedUserDTO->password())) 
        {
            error_log("Usuario autenticado correctamente.");
            return $foundedUserDTO;
        } 

        error_log("Error: Usuario no encontrado o contraseña incorrecta.");
        return false;
    }

    private function buscaUsuario($email)
    {
        error_log("Buscando usuario con email: " . $email);

        $escEmail = $this->realEscapeString($email);
        $conn = application::getInstance()->getConexionBd();

        $query = "SELECT id_usuario, nombre, email, contrasena, foto_perfil, rol FROM usuarios WHERE email = ?";

        error_log("Ejecutando consulta: " . $query);

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            error_log("Error preparando consulta: " . $conn->error);
            return false;
        }

        $stmt->bind_param("s", $escEmail);
        if (!$stmt->execute()) {
            error_log("Error ejecutando consulta: " . $stmt->error);
            return false;
        }

        $stmt->bind_result($id_usuario, $nombre, $email, $contrasena, $fotoPerfil, $rol);

        if ($stmt->fetch()) {
            error_log("Usuario encontrado: ID = " . $id_usuario);
            $user = new userDTO($id_usuario, $nombre, $email, $contrasena, $fotoPerfil, $rol); // Incluye el rol
            $stmt->close();
            return $user;
        } else {
            error_log("Usuario NO encontrado.");
        }

        return false;
    }


    public function create($userDTO)
{
    $createdUserDTO = false;

    try
    {
        $escEmail = $this->realEscapeString($userDTO->email());
        $escNombre = $this->realEscapeString($userDTO->nombre());
        $hashedPassword = self::hashPassword($userDTO->password());
        $fotoPerfil = $userDTO->fotoPerfil();
        $rol = $userDTO->rol(); // Obtén el rol del DTO

        $conn = application::getInstance()->getConexionBd();

        $query = "INSERT INTO usuarios(nombre, email, contrasena, foto_perfil, fecha_registro, rol) VALUES (?, ?, ?, ?, NOW(), ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $escNombre, $escEmail, $hashedPassword, $fotoPerfil, $rol); // Agregar rol a la consulta

        if ($stmt->execute())
        {
            $idUser = $conn->insert_id;
            $createdUserDTO = new userDTO($idUser, $escNombre, $escEmail, $hashedPassword, $fotoPerfil, $rol);

            return $createdUserDTO;
        }
    }
    catch(mysqli_sql_exception $e)
    {
        if ($conn->sqlstate == 23000) 
        { 
            throw new userAlreadyExistException("Ya existe el usuario '{$userDTO->email()}'");
        }
        throw $e;
    }

    return $createdUserDTO;
}


    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private static function testHashPassword($password, $hashedPassword)
    {
        error_log("Verificando contraseña...");
        error_log("Contraseña ingresada: " . $password);
        error_log("Hash almacenado en BD: " . $hashedPassword);

        $result = password_verify($password, $hashedPassword);
        error_log("Resultado de verificación: " . ($result ? "✅ CORRECTO" : "❌ INCORRECTO"));

        return $result;
    }
    /*public function getUserById($id_usuario)
    {
    $conn = application::getInstance()->getConexionBd();
    $query = "SELECT id_usuario, nombre, email, foto_perfil FROM usuarios WHERE id_usuario = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($id, $nombre, $email, $fotoPerfil);

    if ($stmt->fetch()) {
        $stmt->close();
        return new userDTO($id, $nombre, $email, "", $fotoPerfil);
    }

    return null;
    }*/
    public function getUserById($id_usuario)
{
    $conn = application::getInstance()->getConexionBd();
    $query = "SELECT id_usuario, nombre, email, foto_perfil FROM usuarios WHERE id_usuario = ?";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("❌ Error preparando la consulta en getUserById()");
        return null;
    }

    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($id, $nombre, $email, $fotoPerfil);

    if ($stmt->fetch()) {
        $stmt->close();
        error_log("✅ Usuario encontrado: $nombre");
        return new userDTO($id, $nombre, $email, "", $fotoPerfil);
    }

    error_log("⚠️ Usuario con ID $id_usuario no encontrado.");
    return null;
}


public function getProductsByUserId($id_usuario)
{
    $conn = application::getInstance()->getConexionBd();
    $query = "SELECT id_producto, nombre_producto, descripcion, precio, imagen, fecha_publicacion 
              FROM productos WHERE id_usuario = ? ORDER BY fecha_publicacion DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    $stmt->close();
    return $productos;
}


}
?>
