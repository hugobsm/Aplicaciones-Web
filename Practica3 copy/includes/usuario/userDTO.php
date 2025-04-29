<?php

class userDTO
{
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $fotoPerfil;
    private $rol;

    public function __construct($id, $nombre, $email, $password, $fotoPerfil = null, $rol = 'user')
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->fotoPerfil = $fotoPerfil;
        $this->rol = $rol; // Inicializa el rol
    }
    public function id()
    {
        return $this->id;
    }

    public function nombre()
    {
        return $this->nombre;
    }

    public function email()
    {
        return $this->email;
    }

    public function password()
    {
        return $this->password;
    }

    public function fotoPerfil()
    {
        return $this->fotoPerfil;
    }

    public function rol() { return $this->rol; } // Getter del rol
}
?>
