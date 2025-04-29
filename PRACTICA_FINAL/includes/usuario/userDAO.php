<?php

require("IUser.php");
require("userDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");
require("userAlreadyExistException.php");
require_once(__DIR__ . '/../application.php'); // Ajusta la ruta según tu estructura
require_once(__DIR__ . '/../config.php'); // Ajusta la ruta según tu estructura


class userDAO extends baseDAO implements IUser
{
    public function __construct()
    {
    }

    public function login($userDTO)
{
    error_log("Intentando login con email: " . $userDTO->email());
    error_log("Contraseña introducida: " . $userDTO->password());

    $foundedUserDTO = $this->buscaUsuario($userDTO->email());

    if ($foundedUserDTO) {
        error_log("Usuario encontrado en base de datos.");
        error_log("Contraseña en BD (hash): " . $foundedUserDTO->password());

        if (self::testHashPassword($userDTO->password(), $foundedUserDTO->password())) {
            error_log("✅ Login correcto");
            return $foundedUserDTO;
        } else {
            error_log("❌ Contraseña incorrecta");
        }
    } else {
        error_log("❌ Usuario no encontrado");
    }

    return false;
}


    private function buscaUsuario($email)
    {
        error_log("Buscando usuario con email: " . $email);
    
        $escEmail = $this->realEscapeString($email);
        $conn = application::getInstance()->getConexionBd();
    
        $query = "SELECT id_usuario, nombre, email, contrasena, foto_perfil, tipo, edad, genero, pais, telefono, saldo FROM usuarios WHERE email = ?";

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
    
        $stmt->bind_result($id_usuario, $nombre, $email, $contrasena, $fotoPerfil, $tipo, $edad, $genero, $pais, $telefono, $saldo);

    
        if ($stmt->fetch()) {
            error_log("Usuario encontrado: ID = " . $id_usuario);
            $user = new userDTO($id_usuario, $nombre, $email, $contrasena, $fotoPerfil, $tipo, $edad, $genero, $pais, $telefono, $saldo);
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
        $hashedPassword = $userDTO->password();

        $fotoPerfil = $userDTO->fotoPerfil();
        $tipo = $userDTO->tipo();

        $edad = $userDTO->edad();
        $genero = $userDTO->genero();
        $pais = $userDTO->pais();
        $telefono = $userDTO->telefono();

        $conn = application::getInstance()->getConexionBd();

        $query = "INSERT INTO usuarios(nombre, email, contrasena, foto_perfil, tipo, fecha_registro, edad, genero, pais, telefono) 
                  VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("❌ Error preparando el statement: " . $conn->error);
        }

        // Aquí ajustamos correctamente los tipos:
        // s = string, i = integer
        $stmt->bind_param(
            "sssssisss",
            $escNombre,   // s
            $escEmail,    // s
            $hashedPassword, // s
            $fotoPerfil,  // s
            $tipo,        // s
            $edad,        // i
            $genero,      // s
            $pais,        // s
            $telefono     // s
        );

        if ($stmt->execute())
        {
            $idUser = $conn->insert_id;
            $createdUserDTO = new userDTO(
                $idUser,
                $escNombre,
                $escEmail,
                $hashedPassword,
                $fotoPerfil,
                $tipo,
                $userDTO->edad(),
                $userDTO->genero(),
                $userDTO->pais(),
                $userDTO->telefono()
            );
            
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
        $query = "SELECT id_usuario, nombre, email, foto_perfil, tipo, edad, genero, pais, telefono, saldo FROM usuarios WHERE id_usuario = ?";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            error_log("❌ Error preparando la consulta en getUserById()");
            return null;
        }
    
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($id, $nombre, $email, $fotoPerfil, $tipo, $edad, $genero, $pais, $telefono, $saldo);

    
        if ($stmt->fetch()) {
            $stmt->close();
            error_log("✅ Usuario encontrado: $nombre");
            return new userDTO($id, $nombre, $email, "", $fotoPerfil, $tipo, $edad, $genero, $pais, $telefono, $saldo);


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


public function delete(int $id)
{
    $conn = application::getInstance()->getConexionBd();
    $query = "DELETE FROM usuarios WHERE id_usuario = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("❌ Error preparando consulta en delete()");
        return false;
    }

    $stmt->bind_param("i", $id);
    $resultado = $stmt->execute();
    $stmt->close();

    return $resultado;
}

public function findAll()
{
    $conn = application::getInstance()->getConexionBd();
    $query = "SELECT id_usuario, nombre, email, contrasena, foto_perfil, tipo, saldo FROM usuarios";
    
    $result = $conn->query($query);
    $usuarios = [];

    while ($row = $result->fetch_assoc()) {
        $usuarios[] = new userDTO(
            $row['id_usuario'],
            $row['nombre'],
            $row['email'],
            $row['contrasena'],
            $row['foto_perfil'],
            $row['tipo'],
            $row['saldo']
        );
    }

    return $usuarios;
}

public function actualizarPerfil($id_usuario, $nombre, $email, $edad, $genero, $pais, $telefono)
{
    $conn = application::getInstance()->getConexionBd();
    $query = "UPDATE usuarios SET nombre = ?, email = ?, edad = ?, genero = ?, pais = ?, telefono = ? WHERE id_usuario = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisssi", $nombre, $email, $edad, $genero, $pais, $telefono, $id_usuario);
    return $stmt->execute();
}

public function sumarSaldo($id_usuario, $cantidad) {
    $conn = application::getInstance()->getConexionBd();
    $query = "UPDATE usuarios SET saldo = saldo + ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $cantidad, $id_usuario);
    return $stmt->execute();
}

public function restarSaldo($id_usuario, $cantidad) {
    $conn = application::getInstance()->getConexionBd();
    $query = "UPDATE usuarios SET saldo = saldo - ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $cantidad, $id_usuario);
    return $stmt->execute();
}



}
?>
