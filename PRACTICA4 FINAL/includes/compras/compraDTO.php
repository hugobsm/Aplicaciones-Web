<?php

class CompraDTO {
    private $id_compra;
    private $id_usuario;
    private $id_producto;
    private $fecha_compra;
    private $metodo_pago;
    private $id_vendedor;

    public function __construct($id_compra, $id_usuario, $id_producto, $fecha_compra, $metodo_pago, $id_vendedor) {
        $this->id_compra = $id_compra;
        $this->id_usuario = $id_usuario;
        $this->id_producto = $id_producto;
        $this->fecha_compra = $fecha_compra;
        $this->metodo_pago = $metodo_pago;
        $this->id_vendedor = $id_vendedor;
    }

    public function getIdCompra() { return $this->id_compra; }
    public function getIdUsuario() { return $this->id_usuario; }
    public function getIdProducto() { return $this->id_producto; }
    public function getFechaCompra() { return $this->fecha_compra; }
    public function getMetodoPago() { return $this->metodo_pago; }
    public function getIdVendedor() { return $this->id_vendedor; }
}


?>
