<?php

class userDTO
{
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $fotoPerfil;

    public function __construct($id, $nombre, $email, $password, $fotoPerfil = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->fotoPerfil = $fotoPerfil;
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
}
?>
