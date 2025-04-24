<?php
class valoracionMock implements IValoracion {
    public function insertarValoracion($valoracionDTO) {
        return true;
    }

    public function obtenerValoracionesPorVendedor($id_vendedor) {
        return [
            new ValoracionDTO(1, 2, $id_vendedor, 5, "Buen vendedor", "2025-03-21"),
            new ValoracionDTO(2, 3, $id_vendedor, 4, "Rápido envío", "2025-03-22")
        ];
    }
}
?>
