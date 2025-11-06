<?php
    // <!-- Usamos una clase como propiedades privadas para guardar las credenciales de la base de datos (host, usuario, contraseña, y nombre de la BD) -->
    // <!-- Lo hacemos asi para que nadie fuera de la clase pueda aceder o modifics esos datos -->

class Conexion{
    private $host = "localhost";
    private $db = "aventura_go";
    private $user = "root";
    private $pass = "";
    private $conexion;

    // <!-- El constructor (__construct) se ejecuta automáticamente cuando creamos un objeto de la clase y se encarga de la conexión con la base de datos usando PDO  -->

    public function __construct(){
        // <!-- La palabra $this significa literalmente 'esta clase'. La usamos para acceder a las variables internas de la misma clase. -->
        
        // <!-- Por ejemplo, $this->conexión hace referencia a la conexión que pertenece a esta instancia de la clase -->

        try{
            $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            die("Error de conexion: " . $e->getMessage());
        }
    }

    // <!-- Finalmente, el metodo getConexion() sirve para obtener la conexion ya creada.  En vez de abrir una nueva conexion cada vez, simplemente pedimos la que ya exixte dentro del objeto  -->

    public function getConexion(){
        return $this->conexion;
    }
}

// <!-- En resumen:
//     la clase guardqa las credenciales de forma segura .
//     el constructor abre la conexion automaticamente.
//     $this permite acceder a las variables internas de la clase.
//     getConexion() nos devuelve la conexion para poder ejecutar consultas.
//     De esta forma el codigo queda mas limpio, resultable y facil de mantener. -->
?>
