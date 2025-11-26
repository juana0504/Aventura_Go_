<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Definición de la clase login
class Hotelero
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }

    // Función para autenticar usuario (recibe el correo y la clave escrita por el usuario)
    public function registrar($data){

        try {
            $insertar = "INSERT INTO proveedor_hotelero(
            foto,
            nombre_establecimiento,
            tipo_establecimiento,
            numero_habitaciones,
            calificacion_promedio,
            estado
        ) VALUES (
            :foto,
            :nombre_establecimiento,
            :tipo_establecimiento,
            :numero_habitaciones,
            :calificacion_promedio,
            :estado
            )";

            $resultado = $this->conexion->prepare($insertar);
            $resultado->bindParam(':foto', $data['foto']);
            $resultado->bindParam(':nombre_establecimiento', $data['nombre_establecimiento']);
            $resultado->bindParam(':tipo_establecimiento', $data['tipo_establecimiento']);
            $resultado->bindParam(':numero_habitaciones', $data['numero_habitaciones']);
            $resultado->bindParam(':calificacion_promedio', $data['calificacion_promedio']);
            $resultado->bindParam(':estado', $data['estado']);



            return $resultado->execute();
        } catch (PDOException $e) {
            error_log("Error en proveedor::registrar->" . $e->getMessage());
            return false;
        }
    }

    public function listar(){
        try{
            // Variable que almacena laq sentencia de sql a ejecutar
            $consultar = "SELECT * FROM proveedor_hotelero WHERE id_proveedor_hotelero = id_proveedor_hotelero order BY id_proveedor_hotelero DESC";

            // Preparar lo necesario para ejecutar la función
            $resultado = $this->conexion->prepare($consultar);                                                                            
            $resultado->execute();

            return $resultado->fetchAll();
        }catch(PDOException $e){
            error_log("Error en proveedor::listar->" . $e->getMessage());
            return [];

        }
    }

    public function listarHoteles($id){
        try{

            $consultar = "SELECT * FROM proveedor_hotelero WHERE id_proveedor_hotelero = :id_proveedor_hotelero LIMIT 1";

            $resultado = $this->conexion->prepare($consultar);
            $resultado->bindParam(':id_proveedor_hotelero', $id);
            $resultado->execute();

            return $resultado->fetch();
        }catch(PDOexception $e){
            error_log("Error en proveedor::listarHoteles->" . $e->getMessage());
            return;
        }
    }

    public function actualizar($data){
        try{
            $actualizar = "UPDATE proveedor_hotelero SET
                nombre_establecimiento = :nombre_establecimiento,
                tipo_establecimiento = :tipo_establecimiento,
                numero_habitaciones = :numero_habitaciones,
                calificacion_promedio = :calificacion_promedio
            WHERE id_proveedor_hotelero = :id_proveedor_hotelero";

            $resultado = $this->conexion->prepare($actualizar);
            $resultado->bindParam(':id_proveedor_hotelero', $data['id_proveedor_hotelero']);
            $resultado->bindParam(':nombre_establecimiento', $data['nombre_establecimiento']);
            $resultado->bindParam(':tipo_establecimiento', $data['tipo_establecimiento']);
            $resultado->bindParam(':numero_habitaciones', $data['numero_habitaciones']);
            $resultado->bindParam(':calificacion_promedio', $data['calificacion_promedio']);

            return $resultado->execute();
        }catch(PDOException $e){
            error_log("Error al actualizar proveedor::actualizar->" . $e->getMessage());
            return;
        }
    }

    public function eliminar($id){
        try{
            $eliminar = "DELETE FROM proveedor_hotelero WHERE id_proveedor_hotelero = :id_proveedor_hotelero";

            $resultado = $this->conexion->prepare($eliminar);
            $resultado->bindParam(':id_proveedor_hotelero', $id);

            return $resultado->execute();
        }catch(PDOException $e){
            error_log("Error al eliminar proveedor::eliminar->" . $e->getMessage());
            return;
        }
    }
}
