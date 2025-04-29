
<?php
// Configuración para Redsys en modo Sandbox
return [
    'clave' => 'Mk9m98IfEblmPfrpsawt6e1fKmU7MDIm',  // Clave SHA-256 de Redsys pruebas
    'nombre_comercio' => 'Mi Tienda Web',
    'codigo_comercio' => '999008881',  // Código de comercio de sandbox
    'terminal' => '1',
    'moneda' => '978',  // 978 = Euros
    'trans' => "0",   
    'url_ok' => 'http://localhost/includes/compras/respuestaPago.php?status=ok',
    'url_ko' => 'http://localhost/includes/compras/respuestaPago.php?status=ko',
    'url_notificacion' => 'http://localhost/includes/compras/notificacionPago.php'
];