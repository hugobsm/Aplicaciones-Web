<?php

class userDTO {
    private $id;
    private $nombre;
    private $email;
    private $contrasena;
    private $fotoPerfil;
    private $tipo;

    public function __construct($id, $nombre, $email, $contrasena, $fotoPerfil = null, $tipo = 'usuario') {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->fotoPerfil = $fotoPerfil;
        $this->tipo = $tipo;
    }

    // Añade un getter para el tipo:
    public function tipo() {
        return $this->tipo;
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
