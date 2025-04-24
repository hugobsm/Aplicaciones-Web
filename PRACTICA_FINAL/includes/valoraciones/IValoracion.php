<?php
interface IValoracion {
    public function insertarValoracion($valoracionDTO);
    public function obtenerValoracionesPorVendedor($id_vendedor);
}
?>
