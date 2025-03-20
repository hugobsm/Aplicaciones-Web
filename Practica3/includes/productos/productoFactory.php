<?php

require_once("productoDAO.php");
require_once("productoMock.php");

class productoFactory
{
    public static function CreateProducto() : IProducto
    {
        return new productoDAO();
    }
}
?>