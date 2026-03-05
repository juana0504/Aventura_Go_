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
            echo '<pre>';
            echo $e->getMessage();
            echo '</pre>';
            exit;
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
                c.nombre AS destino,
                img.imagen AS imagen_principal
            FROM actividad a
            INNER JOIN ciudades c 
                ON a.id_ciudad = c.id_ciudad
            LEFT JOIN actividad_imagen img 
                ON img.id_actividad = a.id_actividad
               AND img.es_principal = 1
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
        $sql = "UPDATE actividad SET estado = 'ACTIVO' WHERE id_actividad = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    /** Desactivar actividad turística*/
    public function desactivar($id)
    {
        $sql = "UPDATE actividad SET estado = 'INACTIVO' WHERE id_actividad = :id";
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
        WHERE id_actividad = :id_actividad
        AND id_proveedor = :id_proveedor";


        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre'        => $data['nombre'],
            ':id_ciudad'     => $data['id_ciudad'],
            ':ubicacion'     => $data['ubicacion'],
            ':descripcion'   => $data['descripcion'],
            ':cupos'         => $data['cupos'],
            ':precio'        => $data['precio'],
            ':estado'        => $data['estado'],
            ':id_actividad'  => $data['id_actividad'],
            ':id_proveedor'  => $data['id_proveedor']
        ]);
    }


    public function listarActividadesPublicas()
    {
        $sql = "
        SELECT 
            a.id_actividad,
            a.nombre,
            a.precio,
            a.descripcion,
            a.cupos,
            a.ubicacion,
            c.nombre AS ciudad,
            img.imagen
        FROM actividad a
        INNER JOIN proveedor p
            ON a.id_proveedor = p.id_proveedor
        INNER JOIN ciudades c 
            ON a.id_ciudad = c.id_ciudad
        LEFT JOIN actividad_imagen img 
            ON img.id_actividad = a.id_actividad 
        AND img.es_principal = 1
        WHERE a.estado = 'ACTIVO'
        AND p.estado = 'ACTIVO'
        ORDER BY a.created_at DESC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function eliminar($id)
    {
        try {
            $sql = "DELETE FROM actividad WHERE id_actividad = :id_actividad";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_actividad', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar actividad::eliminar -> " . $e->getMessage());
            return false;
        }
    }

    public function listar($id_proveedor)
    {
        try {
            $sql = "SELECT 
            a.*,
            c.nombre AS destino,
            img.imagen AS imagen_principal
        FROM actividad a
        INNER JOIN ciudades c 
        ON a.id_ciudad = c.id_ciudad
        LEFT JOIN actividad_imagen img 
        ON img.id_actividad = a.id_actividad
        AND img.es_principal = 1
        WHERE a.id_proveedor = :id_proveedor
        ORDER BY a.created_at DESC
        ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en actividad::listar -> " . $e->getMessage());
            return [];
        }
    }




    public function obtenerPorId($idActividad)
    {
        $sql = "SELECT 
            a.id_actividad,
            a.nombre,
            a.descripcion,
            a.ubicacion,
            a.cupos,
            a.precio,
            a.estado,
            a.created_at,

            c.nombre AS ciudad,
            d.nombre AS departamento,

            img_principal.imagen AS imagen_principal
        FROM actividad a
        INNER JOIN ciudades c 
            ON a.id_ciudad = c.id_ciudad
        INNER JOIN departamentos d
            ON c.id_departamento = d.id_departamento
        LEFT JOIN actividad_imagen img_principal
            ON img_principal.id_actividad = a.id_actividad
           AND img_principal.es_principal = 1
        WHERE a.id_actividad = :id
        LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idActividad, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    //OBTENER DETALLES DE ACTIVIDADES PARA EL MODAL
    public function obtenerDetalleActividad($id)
    {
        $sql = "
        SELECT 
            a.id_actividad,
            a.nombre,
            a.descripcion,
            a.ubicacion,
            a.cupos,
            a.precio,
            a.estado,
            a.created_at,

            c.nombre AS ciudad,
            d.nombre AS departamento,

            img_principal.imagen AS imagen_principal
            FROM actividad a
            INNER JOIN ciudades c 
                ON a.id_ciudad = c.id_ciudad
            INNER JOIN departamentos d
                ON c.id_departamento = d.id_departamento
            LEFT JOIN actividad_imagen img_principal
                ON img_principal.id_actividad = a.id_actividad
            AND img_principal.es_principal = 1
            WHERE a.id_actividad = :id
            LIMIT 1
            ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $actividad = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$actividad) {
            return null;
        }

        // 🔹 Galería de imágenes
        $sqlImgs = "
        SELECT imagen 
        FROM actividad_imagen 
        WHERE id_actividad = :id
        ORDER BY es_principal DESC
        ";

        $stmtImgs = $this->conexion->prepare($sqlImgs);
        $stmtImgs->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtImgs->execute();

        $actividad['imagenes'] = $stmtImgs->fetchAll(PDO::FETCH_COLUMN);

        return $actividad;
    }



    // SE OBTIENE 1 SOLA ACTIVIDAD PARA TOUR ESCOGIDO
    public function obtenerActividadPorId($id)
    {
        $sql = "
        SELECT a.*
        FROM actividad a
        INNER JOIN proveedor p
        ON a.id_proveedor = p.id_proveedor
        WHERE a.id_actividad = :id
        AND a.estado = 'ACTIVO'
        AND p.estado = 'ACTIVO'
        LIMIT 1
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function descontarCupos($id_actividad, $cantidad)
    {
        $sql = "
        UPDATE actividad
        SET cupos = cupos - :cantidad
        WHERE id_actividad = :id_actividad
          AND cupos >= :cantidad
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id_actividad', $id_actividad, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerFechasLlenas($id_actividad)
    {
        $sql = "SELECT r.fecha FROM reserva r JOIN actividad a ON a.id_actividad = r.id_actividad WHERE r.id_actividad = ? AND r.estado = 'Confirmada' GROUP BY r.fecha, a.cupos HAVING SUM(r.cantidad_personas) >= a.cupos";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_actividad]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function hayCuposDisponibles($idActividad, $fecha, $cantidad)
    {
        $sql = "SELECT cupos FROM actividad WHERE id_actividad = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idActividad, PDO::PARAM_INT);
        $stmt->execute();

        $actividad = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$actividad) {
            return false;
        }

        $cuposTotales = (int)$actividad['cupos'];

        $sql = "SELECT SUM(cantidad_personas) as reservadas
            FROM reserva
            WHERE id_actividad = :id
            AND fecha = :fecha
            AND estado = 'Confirmada'";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idActividad, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $reservadas = (int)($resultado['reservadas'] ?? 0);

        return ($reservadas + $cantidad) <= $cuposTotales;
    }
}
