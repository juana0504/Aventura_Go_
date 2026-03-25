<?php

require_once __DIR__ . '/../../../config/database.php';

// Este modelo se encarga de interactuar con la base de datos para obtener y actualizar la información del proveedor turístico.
// Contiene métodos para obtener la información del proveedor por su ID de usuario, obtener los archivos actuales (logo y foto del representante) y actualizar la información del proveedor con los datos proporcionados.
class ProveedorModel
{

    // La conexión a la base de datos se establece en el constructor, utilizando la clase de conexión definida en el archivo de configuración.
    private $conexion;

    // El constructor crea una nueva instancia de la clase de conexión y obtiene la conexión a la base de datos para usarla en los métodos del modelo.
    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }



    // Obtener proveedor por usuario
    public function obtenerPorUsuario($idUsuario)
    {
        $sql = "SELECT p.*, u.email AS email_login
                FROM proveedor p
                JOIN usuario u ON p.id_usuario = u.id_usuario
                WHERE p.id_usuario = :id
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    // Obtener logo y foto actual
    public function obtenerArchivosActuales($idUsuario)
    {
        $sql = "SELECT logo, foto_representante 
                FROM proveedor 
                WHERE id_usuario = :id 
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    // Actualizar proveedor
    public function actualizar($data)
    {

        $sql = "UPDATE proveedor SET
            nombre_empresa = :nombre_empresa,
            nit_rut = :nit_rut,
            email = :email,
            telefono = :telefono,
            direccion = :direccion,
            nombre_representante = :nombre_representante,
            identificacion_representante = :identificacion_representante,
            telefono_representante = :telefono_representante,
            id_ciudad = :id_ciudad,
            tipo_documento = :tipo_documento,
            departamento = :departamento,
            actividades = :actividades,
            descripcion = :descripcion,
            logo = :logo,
            foto_representante = :foto_representante,
            estado = 'EN_REVISION'
        WHERE id_usuario = :id_usuario";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute($data);
    }



    // Método para actualizar la información del proveedor, similar al método actualizar pero con una estructura de datos diferente.
    public function actualizarProveedor($data)
    {

        $sql = "UPDATE proveedor SET
        nombre_empresa = :nombre_empresa,
        nit_rut = :nit_rut,
        email = :email,
        telefono = :telefono,
        direccion = :direccion,
        nombre_representante = :nombre_representante,
        identificacion_representante = :identificacion_representante,
        telefono_representante = :telefono_representante,
        id_ciudad = :id_ciudad,
        tipo_documento = :tipo_documento,
        departamento = :departamento,
        actividades = :actividades,
        descripcion = :descripcion,
        logo = :logo,
        foto_representante = :foto_representante,
        estado = 'EN_REVISION'
    WHERE id_usuario = :id_usuario";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute($data);
    }
}
