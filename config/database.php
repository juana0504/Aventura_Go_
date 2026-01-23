<?php
//usamos una clase con popiedades pivadas para guardadr credenciales de la base de datos(hos, usuaio, contraseña y nombre de la BD)

//lo hacemos asi para que nadie fuera de la clase pueda acceder o modificar esos datos especificamente

class conexion
{
    private $host = "localhost";
    private $db = "aventura_go";
    private $user = "root";
    private $pass = "";
    private $conexion;

    //el constructor (_construct) se ejecuta automaticamente cuando creamos un objeto de la clase y se encarga de abrir la conexion a la base de datos usando PDO
    public function __construct()
    {
        //la palabra $this significa literalmente "esta clase".la usamos para acceder las variables internas de la misma clase. 
        //por ejemplo , $this->conexion hace referencia a la conec¿xion que pertenece a esta instancia de la clase-->$_COOKIE

        try {
            $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexion " . $e->getMessage());
        }
    }

    //finalmente, el metodo getConexion() sirve para obtener la conexion ya creada
    //en vez de abrir una nueva conexion cada vez, simplemente pedimos la que ya existe dentro del objeto

    public function getConexion()
    {
        return $this->conexion;
    }
}

//en resumen:
//la clase guarda las credenciales de forma segura
//el constructor abre la conexion automaticamente.
//this permite acceder a las variables internas de la clase.
//getConexion() nos devuelve la conexion para poder ejecutar consultas.
//de esta forma el codigo queda mas limpio, reutilizable y facil de mantener
