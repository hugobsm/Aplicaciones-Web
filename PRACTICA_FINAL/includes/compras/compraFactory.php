<?php

require("compraDAO.php");

class compraFactory {
    public static function CreateCompra(): ICompra {
        return new compraDAO();
    }
}

?>
