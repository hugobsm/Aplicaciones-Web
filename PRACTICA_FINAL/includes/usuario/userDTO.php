<?php

class userDTO {
    private $id;
    private $nombre;
    private $email;
    private $contrasena;
    private $fotoPerfil;
    private $tipo;
    private $edad;
    private $genero;
    private $pais;
    private $telefono;
    private $saldo;

    public function __construct($id, $nombre, $email, $contrasena, $fotoPerfil = null, $tipo = 'usuario', $edad = null, $genero = null, $pais = null, $telefono = null, $saldo = 0) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->fotoPerfil = $fotoPerfil;
        $this->tipo = $tipo;
        $this->edad = $edad;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->telefono = $telefono;
        $this->saldo = $saldo;
    }

    public function id() {
        return $this->id;
    }

    public function nombre() {
        return $this->nombre;
    }

    public function email() {
        return $this->email;
    }

    public function password() {
        return $this->contrasena;
    }

    public function fotoPerfil() {
        return $this->fotoPerfil;
    }

    public function tipo() {
        return $this->tipo;
    }

    public function edad() {
        return $this->edad;
    }

    public function genero() {
        return $this->genero;
    }

    public function pais() {
        return $this->pais;
    }

    public function telefono() {
        return $this->telefono;
    }

    public function saldo() {
        return $this->saldo;
    }

    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }
}
?>
