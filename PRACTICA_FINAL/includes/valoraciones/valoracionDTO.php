<?php
class ValoracionDTO {
    private $id_valoracion;
    private $id_comprador;
    private $id_vendedor;
    private $puntuacion;
    private $comentario;
    private $fecha_valoracion;
    private $id_producto;

    public function __construct($id_valoracion, $id_comprador, $id_vendedor, $id_producto, $puntuacion, $comentario, $fecha_valoracion) {
        $this->id_valoracion = $id_valoracion;
        $this->id_comprador = $id_comprador;
        $this->id_vendedor = $id_vendedor;
        $this->id_producto = $id_producto;
        $this->puntuacion = $puntuacion;
        $this->comentario = $comentario;
        $this->fecha_valoracion = $fecha_valoracion;
    }

    public function getIdValoracion() { return $this->id_valoracion; }
    public function getIdComprador() { return $this->id_comprador; }
    public function getIdVendedor() { return $this->id_vendedor; }
    public function getPuntuacion() { return $this->puntuacion; }
    public function getComentario() { return $this->comentario; }
    public function getFechaValoracion() { return $this->fecha_valoracion; }
    public function getIdProducto() {return $this->id_producto;}
}
?>
