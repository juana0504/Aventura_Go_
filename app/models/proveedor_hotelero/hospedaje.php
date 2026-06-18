<?php

/** Modelo ActividadTuristica / Maneja toda la lógica de base de datos /  relacionada con las actividades turísticas*/

// Incluye la configuración de la base de datos
require_once __DIR__ . '/../../../config/database.php';



class Hospedaje
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
            $sql = "INSERT INTO hospedaje (
                id_proveedor_hotelero,
                nombre,
                descripcion,
                tipo,
                id_ciudad,
                ubicacion,
                capacidad,
                precio,
                servicios,
                estado,
                imagen
            ) VALUES (
                :id_proveedor_hotelero,
                :nombre,
                :descripcion,
                :tipo,
                :id_ciudad,
                :ubicacion,
                :capacidad,
                :precio,
                :servicios,
                :estado,
                :imagen
            )";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':id_proveedor_hotelero' => $data['id_proveedor_hotelero'],
                ':nombre'                => $data['nombre'],
                ':descripcion'           => $data['descripcion'] ?? '',
                ':tipo'                  => $data['tipo'],
                ':id_ciudad'             => $data['id_ciudad'],
                ':ubicacion'             => $data['ubicacion'],
                ':capacidad'             => $data['capacidad'],
                ':precio'                => $data['precio'],
                ':servicios'             => $data['servicios'],
                ':estado'                => $data['estado'],
                ':imagen'                => $data['imagen']
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
        $sql = "INSERT INTO hospedaje_imagen (
        id_hospedaje,
        imagen,
        es_principal
        ) VALUES (
            :id_hospedaje,
            :imagen,
            :es_principal
        )";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_hospedaje' => $data['id_hospedaje'],
            ':imagen'       => $data['imagen'],
            ':es_principal' => $data['es_principal']
        ]);
    }

    /** Listar todas las actividades de un proveedor */
    public function listarPorProveedor($id_proveedor_hotelero)
    {
        try {
            $sql = "SELECT
                    a.*,
                    c.nombre AS destino
                FROM hospedaje a
                LEFT JOIN ciudades c
                    ON a.id_ciudad = c.id_ciudad
                WHERE a.id_proveedor_hotelero = :id_proveedor_hotelero
                ORDER BY a.id_hospedaje DESC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor_hotelero', $id_proveedor_hotelero, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Hospedaje::listarPorProveedor error: ' . $e->getMessage());
            return [];
        }
    }

    /** Listar una actividad por su ID */
    public function listarPorId($id)
    {
        $sql = "SELECT * FROM hospedaje WHERE id_hospedaje = :id";


        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Activar hospedaje*/
    public function activar($id)
    {
        $sql = "UPDATE hospedaje SET estado = 'ACTIVO' WHERE id_hospedaje = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** Desactivar actividad turística*/
    public function desactivar($id)
    {
        $sql = "UPDATE hospedaje SET estado = 'INACTIVO' WHERE id_hospedaje = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** Actualizar hospedaje */
    public function actualizarHospedaje($data)
    {
        $sql = "UPDATE hospedaje SET
            nombre = :nombre,
            descripcion = :descripcion,
            tipo = :tipo,
            id_ciudad = :id_ciudad,
            ubicacion = :ubicacion,
            capacidad = :capacidad,
            precio = :precio,
            servicios = :servicios,
            estado = :estado
        WHERE id_hospedaje = :id_hospedaje"
            . " AND id_proveedor_hotelero = :id_proveedor_hotelero";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre'                => $data['nombre'],
            ':descripcion'           => $data['descripcion'],
            ':tipo'                  => is_array($data['tipo']) ? implode(', ', $data['tipo']) : $data['tipo'],
            ':id_ciudad'             => $data['id_ciudad'],
            ':ubicacion'             => $data['ubicacion'],
            ':capacidad'             => $data['capacidad'],
            ':precio'                => $data['precio'],
            ':servicios'             => $data['servicios'],
            ':estado'                => $data['estado'],
            ':id_hospedaje'          => $data['id_hospedaje'],
            ':id_proveedor_hotelero' => $data['id_proveedor_hotelero'],
        ]);
    }


    public function listarActividadesPublicas()
    {
        $sql = "
        SELECT 
           h.id_hospedaje,
           h.nombre,
           h.descripcion,
           h.precio,
           h.capacidad,
           h.ubicacion,
            c.nombre AS ciudad,
            img.imagen
        FROM hospedaje h
        INNER JOIN proveedor_hotelero p
            ON h.id_proveedor_hotelero = p.id_proveedor_hotelero
        INNER JOIN ciudades c 
            ON h.id_ciudad = c.id_ciudad
        LEFT JOIN hospedaje_imagen img 
            ON img.id_hospedaje = h.id_hospedaje 
        AND img.es_principal = 1
        WHERE h.estado = 'ACTIVO'
        AND p.estado = 'ACTIVO'
        ORDER BY h.created_at DESC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCiudad($ciudad)
    {
        $sql = "
    SELECT 
        h.id_hospedaje,
        h.nombre,
        h.descripcion,
        h.precio,
        h.capacidad,
        h.ubicacion,
        c.nombre AS ciudad,
        img.imagen
    FROM hospedaje h
    INNER JOIN proveedor_hotelero p
        ON h.id_proveedor_hotelero = p.id_proveedor_hotelero
    INNER JOIN ciudades c 
        ON h.id_ciudad = c.id_ciudad
    LEFT JOIN hospedaje_imagen img 
        ON img.id_hospedaje = h.id_hospedaje 
        AND img.es_principal = 1
    WHERE h.estado = 'ACTIVO'
    AND p.estado = 'ACTIVO'
    AND UPPER(c.nombre) = UPPER(:ciudad)
    ORDER BY h.created_at DESC
    ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id)
    {
        try {
            $sql = "DELETE FROM hospedaje WHERE id_hospedaje = :id_hospedaje";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_hospedaje', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar hospedaje::eliminar -> " . $e->getMessage());
            return false;
        }
    }

    public function listar($id_proveedor_hotelero)
    {
        try {
            $sql = "SELECT 
            h.*,
            c.nombre AS destino,
            img.imagen AS imagen_principal
        FROM hospedaje h
        INNER JOIN ciudades c 
        ON h.id_ciudad = c.id_ciudad
        LEFT JOIN hospedaje_imagen img 
        ON img.id_hospedaje = h.id_hospedaje
        AND img.es_principal = 1
        WHERE h.id_proveedor_hotelero = :id_proveedor_hotelero
        ORDER BY h.created_at DESC
        ";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor_hotelero', $id_proveedor_hotelero, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en hospedaje::listar -> " . $e->getMessage());
            return [];
        }
    }

    /**
     * Cuenta las actividades registradas por un proveedor.
     */
    public function contarPorProveedor($id_proveedor_hotelero)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM hospedaje WHERE id_proveedor_hotelero = :id_proveedor_hotelero";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor_hotelero', $id_proveedor_hotelero, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (int) $row['total'] : 0;
        } catch (PDOException $e) {
            error_log("Error en hospedaje::contarPorProveedor -> " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerPorId($idActividad)
    {
        $sql = "SELECT
        h.id_hospedaje,
        h.nombre,
        h.descripcion,
        h.precio,
        h.imagen,
        h.created_at,
        h.imagen AS imagen_principal,
        c.nombre AS ciudad,
        d.nombre AS departamento
    FROM hospedaje h
    INNER JOIN ciudades c
        ON h.id_ciudad = c.id_ciudad
    INNER JOIN departamentos d
        ON c.id_departamento = d.id_departamento
    WHERE h.id_hospedaje = :id
    LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idActividad, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    //OBTENER DETALLES DE HOSPEDAJE PARA EL MODAL
    public function obtenerDetalleActividad($id)
    {
        $sql = "
        SELECT
            h.id_hospedaje,
            h.nombre,
            h.descripcion,
            h.ubicacion,
            h.capacidad,
            h.precio,
            h.imagen,
            h.estado,
            h.created_at,
            h.imagen AS imagen_principal,
            c.nombre AS ciudad,
            d.nombre AS departamento
            FROM hospedaje h
            INNER JOIN ciudades c
                ON h.id_ciudad = c.id_ciudad
            INNER JOIN departamentos d
                ON c.id_departamento = d.id_departamento
            WHERE h.id_hospedaje = :id
            LIMIT 1
            ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $actividad = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$actividad) {
            return null;
        }

        $actividad['imagenes'] = $actividad['imagen'] ? [$actividad['imagen']] : [];

        return $actividad;
    }



    // SE OBTIENE 1 SOLO HOSPEDAJE
    public function obtenerActividadPorId($id)
    {
        $sql = "
        SELECT h.*
        FROM hospedaje h
        INNER JOIN proveedor_hotelero ph
        ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
        WHERE h.id_hospedaje = :id
        AND h.estado = 'ACTIVO'
        AND ph.estado = 'ACTIVO'
        LIMIT 1
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPublico($id)
    {
        try {
            $sql = "SELECT
                h.id_hospedaje,
                h.nombre,
                h.descripcion,
                h.tipo,
                h.ubicacion,
                h.capacidad,
                h.precio,
                h.servicios,
                h.imagen,
                h.estado,
                c.nombre AS ciudad,
                d.nombre AS departamento,
                ph.logo AS logo_proveedor,
                ph.nombre_establecimiento
            FROM hospedaje h
            INNER JOIN ciudades c ON h.id_ciudad = c.id_ciudad
            INNER JOIN departamentos d ON c.id_departamento = d.id_departamento
            INNER JOIN proveedor_hotelero ph ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
            WHERE h.id_hospedaje = :id
            AND h.estado = 'ACTIVO'
            AND ph.estado = 'ACTIVO'
            LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Hospedaje::obtenerPublico: " . $e->getMessage());
            return null;
        }
    }

    public function descontarcapacidad($id_hospedaje, $cantidad)
    {
        $sql = "
        UPDATE hospedaje
        SET capacidad = capacidad - :cantidad
        WHERE id_hospedaje = :id_hospedaje
          AND capacidad >= :cantidad
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id_hospedaje', $id_hospedaje, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerFechasLlenas($id_hospedaje)
    {
        $sql = "SELECT r.fecha FROM reserva r JOIN hospedaje h ON h.id_hospedaje = r.id_hospedaje WHERE r.id_hospedaje = ? AND r.estado = 'Confirmada' GROUP BY r.fecha, h.capacidad HAVING SUM(r.cantidad_personas) >= h.capacidad";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id_hospedaje]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function haycapacidadDisponibles($idHospedaje, $fecha, $cantidad)
    {
        $sql = "SELECT capacidad FROM hospedaje WHERE id_hospedaje = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idHospedaje, PDO::PARAM_INT);
        $stmt->execute();

        $actividad = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$actividad) {
            return false;
        }

        $capacidadTotales = (int)$actividad['capacidad'];

        $sql = "SELECT SUM(cantidad_personas) as reservadas
            FROM reserva
            WHERE id_hospedaje = :id
            AND fecha = :fecha
            AND estado = 'Confirmada'";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $idHospedaje, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $reservadas = (int)($resultado['reservadas'] ?? 0);

        return ($reservadas + $cantidad) <= $capacidadTotales;
    }

    public function listarPublicos()
    {
        try {
            $sql = "SELECT
                h.id_hospedaje,
                h.nombre,
                h.tipo,
                h.descripcion,
                h.precio,
                h.capacidad,
                h.imagen,
                h.imagen AS imagen_card,
                ph.logo,
                ph.nombre_establecimiento,
                ph.tipo_establecimiento,
                c.nombre AS ciudad,
                0 AS cupos_reservados
            FROM hospedaje h
            INNER JOIN proveedor_hotelero ph
                ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
            INNER JOIN ciudades c
                ON h.id_ciudad = c.id_ciudad
            WHERE h.estado = 'ACTIVO'
            AND ph.estado = 'ACTIVO'
            ORDER BY h.created_at DESC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Hospedaje::listarPublicos: " . $e->getMessage());
            return [];
        }
    }

    public function listarPublicosPorCiudad($ciudad)
    {
        try {
            $sql = "SELECT
                h.id_hospedaje,
                h.nombre,
                h.tipo,
                h.descripcion,
                h.precio,
                h.capacidad,
                h.imagen,
                h.imagen AS imagen_card,
                ph.logo,
                ph.nombre_establecimiento,
                ph.tipo_establecimiento,
                c.nombre AS ciudad,
                0 AS cupos_reservados
            FROM hospedaje h
            INNER JOIN proveedor_hotelero ph
                ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
            INNER JOIN ciudades c
                ON h.id_ciudad = c.id_ciudad
            WHERE h.estado = 'ACTIVO'
            AND ph.estado = 'ACTIVO'
            AND UPPER(c.nombre) = UPPER(:ciudad)
            ORDER BY h.created_at DESC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Hospedaje::listarPublicosPorCiudad: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPublicos(string $q): array
    {
        try {
            $like = '%' . $q . '%';
            $sql = "
                SELECT
                    h.id_hospedaje,
                    h.nombre,
                    h.tipo,
                    h.descripcion,
                    h.precio,
                    h.capacidad,
                    h.imagen,
                    h.imagen AS imagen_card,
                    ph.logo,
                    ph.nombre_establecimiento,
                    ph.tipo_establecimiento,
                    c.nombre AS ciudad,
                    0 AS cupos_reservados
                FROM hospedaje h
                INNER JOIN proveedor_hotelero ph
                    ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
                INNER JOIN ciudades c
                    ON h.id_ciudad = c.id_ciudad
                WHERE h.estado = 'ACTIVO'
                AND ph.estado = 'ACTIVO'
                AND (h.nombre LIKE :q1 OR h.tipo LIKE :q2 OR c.nombre LIKE :q3
                     OR ph.nombre_establecimiento LIKE :q4)
                ORDER BY h.nombre ASC
            ";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([':q1' => $like, ':q2' => $like, ':q3' => $like, ':q4' => $like]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Hospedaje::buscarPublicos: " . $e->getMessage());
            return [];
        }
    }
}
