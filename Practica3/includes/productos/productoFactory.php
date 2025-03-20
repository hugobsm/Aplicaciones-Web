<?php

require("productoDAO.php");
require("productoMock.php");

class productoFactory
{
    public static function CreateProducto(): IProducto
    {
        $productoDAO = false;

        if (true) // Aquí puedes agregar una condición para alternar entre DAO y Mock
        {
            $productoDAO = new productoDAO();
        }
        else
        {
            $productoDAO = new productoMock();
        }

        return $productoDAO;
    }
}

?>
