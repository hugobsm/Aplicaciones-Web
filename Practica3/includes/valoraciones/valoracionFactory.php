<?php
require_once("valoracionDAO.php");
require_once("valoracionMock.php");

class valoracionFactory {
    public static function CreateValoracion(): IValoracion {
        return new valoracionDAO(); // NO usar valoracionMock()
    }
    
}
?>
