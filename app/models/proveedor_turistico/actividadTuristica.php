<?php

/** Modelo ActividadTuristica / Maneja toda la lógica de base de datos /  relacionada con las actividades turísticas*/

// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../../config/database.php';



class ActividadTuristica
{
    private $conexion; // Propiedad para almacenar la conexión a la base de datos

    // Constructor: se ejecuta automáticamente cuando se crea el objeto
    public function __construct()
    {
        $db = new conexion(); // Crea una nueva instancia de la clase conexion (config/database.php)
        $this->conexion = $db->getConexion(); // Obtiene la conexión PDO y la guarda en $this->conexion
    }



    /** Registrar una nueva actividad turística */
    public function registrar($data)
    {
        try {
            $sql = "INSERT INTO actividad (
            id_proveedor,
            nombre,
            id_ciudad,
            ubicacion,
            descripcion,
            cupos,
            precio,
            estado,
            imagen
        ) VALUES (
            :id_proveedor,
            :nombre,
            :id_ciudad,
            :ubicacion,
            :descripcion,
            :cupos,
            :precio,
            :estado,
            :imagen
        )";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':id_proveedor' => $data['id_proveedor'],
                ':nombre'       => $data['nombre'],
                ':id_ciudad'    => $data['id_ciudad'],
                ':ubicacion'    => $data['ubicacion'],
                ':descripcion'  => $data['descripcion'],
                ':cupos'        => $data['cupos'],
                ':precio'       => $data['precio'],
                ':estado'       => $data['estado'],
                ':imagen'       => $data['imagen']
            ]);

            // 🔥 DEVOLVEMOS EL ID DE LA ACTIVIDAD
            return $this->conexion->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }



    public function guardarImagen($data)
    {
        $sql = "INSERT INTO actividad_imagen (
        id_actividad,
        imagen,
        es_principal
    ) VALUES (
        :id_actividad,
        :imagen,
        :es_principal
    )";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_actividad' => $data['id_actividad'],
            ':imagen'       => $data['imagen'],
            ':es_principal' => $data['es_principal']
        ]);
    }




    /** Listar todas las actividades de un proveedor */
    public function listarPorProveedor($id_proveedor)
    {
        $sql = "SELECT 
                    a.*,
                    d.nombre AS destino
                FROM actividad a
                INNER JOIN destino d ON a.id_ciudad = d.id_ciudad
                WHERE a.id_proveedor = :id_proveedor
                ORDER BY a.created_at DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    /** Listar una actividad por su ID */
    public function listarPorId($id)
    {
        $sql = "SELECT * FROM actividad WHERE id_actividad = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    /** Activar actividad turística*/
    public function activar($id)
    {
        $sql = "UPDATE actividad SET estado = 'activa' WHERE id_actividad = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }



    /** Desactivar actividad turística*/
    public function desactivar($id)
    {
        $sql = "UPDATE actividad SET estado = 'pausada' WHERE id_actividad = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** Actualizar actividad turística(para futuro uso: edición) */
    public function actualizarActividad($data)
    {
        $sql = "UPDATE actividad SET
                    nombre      = :nombre,
                    id_ciudad   = :id_ciudad,
                    ubicacion   = :ubicacion,
                    descripcion = :descripcion,
                    cupos       = :cupos,
                    precio      = :precio,
                    estado      = :estado
                WHERE id_actividad = :id_actividad";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre'        => $data['nombre'],
            ':id_ciudad'    => $data['id_ciudad'],
            ':ubicacion'     => $data['ubicacion'],
            ':descripcion'   => $data['descripcion'],
            ':cupos'         => $data['cupos'],
            ':precio'        => $data['precio'],
            ':estado'        => $data['estado'],
            ':id_actividad'  => $data['id_actividad']
        ]);
    }
}
