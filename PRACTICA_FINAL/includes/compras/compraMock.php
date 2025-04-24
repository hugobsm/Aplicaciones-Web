<?php

class CompraMock implements ICompra
{
    public function registrarCompra($compraDTO)
    {
        return true;
    }

    public function obtenerComprasPorUsuario($idUsuario)
    {
        return [];
    }
}
?>
