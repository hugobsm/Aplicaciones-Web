<?php

class ProductoDTO {
    private $id;
    private $id_usuario;
    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;
    private $fecha_publicacion;

    public function __construct($id, $id_usuario, $nombre, $descripcion, $precio, $fecha_publicacion, $imagen) {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
        $this->fecha_publicacion = $fecha_publicacion;
    }

    public function getId() { return $this->id; }
    public function getIdUsuario() { return $this->id_usuario; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecio() { return $this->precio; }
    public function getImagen() { return $this->imagen; }
    public function getFechaPublicacion() { return $this->fecha_publicacion; }
}

?>