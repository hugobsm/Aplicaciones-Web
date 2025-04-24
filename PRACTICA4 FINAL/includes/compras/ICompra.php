<?php

interface ICompra {
    public function realizarCompra($compraDTO);
    public function obtenerComprasPorUsuario($id_usuario);
}

?>
