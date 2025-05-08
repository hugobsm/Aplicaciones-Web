<?php 

class Application
{
    private static $instancia;
    private $bdDatosConexion;
    private $inicializada = false;
    private $conn;
    private $atributosPeticion;

    const ATRIBUTOS_PETICION = 'attsPeticion';

    public static function getInstance() 
    {
        if (!self::$instancia instanceof self) 
        {
            self::$instancia = new static();
        }
        return self::$instancia;
    }

    private function __construct()
    {
    }

    public function init($bdDatosConexion)
    {
        if (!$this->inicializada) 
        {
            $this->bdDatosConexion = $bdDatosConexion;
            $this->inicializada = true;
            //session_start();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->atributosPeticion = $_SESSION[self::ATRIBUTOS_PETICION] ?? [];
            unset($_SESSION[self::ATRIBUTOS_PETICION]);
        }
    }

    public function shutdown()
    {
        $this->compruebaInstanciaInicializada();
        if ($this->conn !== null && !$this->conn->connect_errno) 
        {
            $this->conn->close();
        }
    }

    private function compruebaInstanciaInicializada()
    {
        if (!$this->inicializada) 
        {
            echo "Aplicación no inicializada";
            exit();
        }
    }

    public function getConexionBd()
    {
        $this->compruebaInstanciaInicializada();

        if (!$this->conn) 
        {
            $bdHost = $this->bdDatosConexion['host'];
            $bdUser = $this->bdDatosConexion['user'];
            $bdPass = $this->bdDatosConexion['pass'];
            $bd     = $this->bdDatosConexion['bd'];

            $conn = new mysqli($bdHost, $bdUser, $bdPass, $bd);

            if ($conn->connect_errno) 
            {
                echo "Error de conexión a la BD ({$conn->connect_errno}):  {$conn->connect_error}";
                exit();
            }

            if (!$conn->set_charset("utf8mb4")) 
            {
                echo "Error al configurar la BD ({$conn->errno}):  {$conn->error}";
                exit();
            }

            $this->conn = $conn;
        }

        return $this->conn;
    }

    public function putAtributoPeticion($clave, $valor)
    {
        if (!isset($_SESSION[self::ATRIBUTOS_PETICION])) {
            $_SESSION[self::ATRIBUTOS_PETICION] = [];
        }
        $_SESSION[self::ATRIBUTOS_PETICION][$clave] = $valor;
    }

    public function getAtributoPeticion($clave)
    {
        return $this->atributosPeticion[$clave] ?? $_SESSION[self::ATRIBUTOS_PETICION][$clave] ?? null;
    }
}
?>
