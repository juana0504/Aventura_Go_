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



    public function actualizarImagenPrincipal($id_actividad, $imagen)
    {
        try {
            $stmt = $this->conexion->prepare("UPDATE actividad SET imagen = :imagen WHERE id_actividad = :id");
            return $stmt->execute([':imagen' => $imagen, ':id' => (int)$id_actividad]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function eliminarImagenes($id_actividad)
    {
        try {
            $stmt = $this->conexion->prepare("DELETE FROM actividad_imagen WHERE id_actividad = :id");
            return $stmt->execute([':id' => (int)$id_actividad]);
        } catch (PDOException $e) {
            return true;
        }
    }

    public function guardarImagen($data)
    {
        try {
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
        } catch (PDOException $e) {
            return false;
        }
    }




    /** Listar todas las actividades de un proveedor */
    public function listarPorProveedor($id_proveedor)
    {
        $sql = "SELECT
                a.*,
                c.nombre AS destino,
                COALESCE(ai.imagen, a.imagen) AS imagen_principal
            FROM actividad a
            INNER JOIN ciudades c
                ON a.id_ciudad = c.id_ciudad
            LEFT JOIN actividad_imagen ai
                ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
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


    /** Listar actividad con ciudad/departamento para modal */
    public function listarParaModal($id)
    {
        $sql = "SELECT a.*,
                       COALESCE(ai.imagen, a.imagen) AS imagen_principal,
                       c.nombre AS ciudad,
                       d.nombre AS departamento
                FROM actividad a
                LEFT JOIN ciudades c ON a.id_ciudad = c.id_ciudad
                LEFT JOIN departamentos d ON c.id_departamento = d.id_departamento
                LEFT JOIN actividad_imagen ai
                    ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
                WHERE a.id_actividad = :id
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        // Galería: intentar desde actividad_imagen; fallback a imagen principal
        $imagenes = [];
        try {
            $sqlImg = "SELECT imagen FROM actividad_imagen WHERE id_actividad = :id ORDER BY es_principal DESC";
            $stmtImg = $this->conexion->prepare($sqlImg);
            $stmtImg->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtImg->execute();
            $imagenes = $stmtImg->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) { }

        if (empty($imagenes) && !empty($data['imagen'])) {
            $imagenes = [$data['imagen']];
        }

        $data['imagenes'] = $imagenes;

        return $data;
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
            COALESCE(ai.imagen, a.imagen) AS imagen
        FROM actividad a
        INNER JOIN proveedor p
            ON a.id_proveedor = p.id_proveedor
        INNER JOIN ciudades c
            ON a.id_ciudad = c.id_ciudad
        LEFT JOIN actividad_imagen ai
            ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
        WHERE a.estado = 'ACTIVO'
        AND p.estado = 'ACTIVO'
        ORDER BY a.created_at DESC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCiudad($ciudad)
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
        COALESCE(ai.imagen, a.imagen) AS imagen
    FROM actividad a
    INNER JOIN proveedor p
        ON a.id_proveedor = p.id_proveedor
    INNER JOIN ciudades c
        ON a.id_ciudad = c.id_ciudad
    LEFT JOIN actividad_imagen ai
        ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
    WHERE a.estado = 'ACTIVO'
    AND p.estado = 'ACTIVO'
    AND UPPER(c.nombre) = UPPER(:ciudad)
    ORDER BY a.created_at DESC
    ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarDestinosPopulares()
    {
        $sql = "
            SELECT
                c.id_ciudad,
                c.nombre AS ciudad,
                COUNT(DISTINCT a.id_actividad) AS total_actividades,
                COALESCE(
                    MIN(CASE WHEN ai.es_principal = 1 THEN ai.imagen END),
                    MIN(a.imagen)
                ) AS imagen_destino
            FROM ciudades c
            INNER JOIN actividad a
                ON c.id_ciudad = a.id_ciudad AND a.estado = 'ACTIVO'
            INNER JOIN proveedor p
                ON a.id_proveedor = p.id_proveedor AND p.estado = 'ACTIVO'
            LEFT JOIN actividad_imagen ai
                ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
            GROUP BY c.id_ciudad, c.nombre
            ORDER BY total_actividades DESC
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
            a.imagen AS imagen_principal
        FROM actividad a
        INNER JOIN ciudades c
        ON a.id_ciudad = c.id_ciudad
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

    /**
     * Cuenta las actividades registradas por un proveedor.
     */
    public function contarPorProveedor($id_proveedor)
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM actividad WHERE id_proveedor = :id_proveedor";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (int) $row['total'] : 0;
        } catch (PDOException $e) {
            error_log("Error en actividad::contarPorProveedor -> " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerPorId($idActividad)
    {
        $sql = "SELECT
        a.id_actividad,
        a.nombre,
        a.precio,
        a.created_at,
        COALESCE(ai.imagen, a.imagen) AS imagen_principal,
        c.nombre AS ciudad,
        d.nombre AS departamento
    FROM actividad a
    INNER JOIN ciudades c
        ON a.id_ciudad = c.id_ciudad
    INNER JOIN departamentos d
        ON c.id_departamento = d.id_departamento
    LEFT JOIN actividad_imagen ai
        ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
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
            COALESCE(ai.imagen, a.imagen) AS imagen_principal,
            c.nombre AS ciudad,
            d.nombre AS departamento
            FROM actividad a
            INNER JOIN ciudades c
                ON a.id_ciudad = c.id_ciudad
            INNER JOIN departamentos d
                ON c.id_departamento = d.id_departamento
            LEFT JOIN actividad_imagen ai
                ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
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

        // Galería: todas las imágenes subidas, principal primero
        $sqlImg = "SELECT imagen FROM actividad_imagen WHERE id_actividad = :id ORDER BY es_principal DESC";
        $stmtImg = $this->conexion->prepare($sqlImg);
        $stmtImg->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtImg->execute();
        $imagenes = $stmtImg->fetchAll(PDO::FETCH_COLUMN);

        $actividad['imagenes'] = !empty($imagenes) ? $imagenes : ($actividad['imagen_principal'] ? [$actividad['imagen_principal']] : []);

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

    public function listarPopulares(int $limite = 8): array
    {
        $sql = "
            SELECT
                a.id_actividad,
                a.nombre,
                a.precio,
                a.descripcion,
                c.nombre AS ciudad,
                COALESCE(MIN(ai.imagen), a.imagen) AS imagen,
                COUNT(DISTINCT r.id_reserva)          AS total_reservas,
                COUNT(DISTINCT res.id_resena)          AS total_resenas,
                COALESCE(AVG(res.calificacion), 0)    AS promedio_calificacion
            FROM actividad a
            INNER JOIN proveedor p  ON a.id_proveedor = p.id_proveedor
            INNER JOIN ciudades  c  ON a.id_ciudad    = c.id_ciudad
            LEFT JOIN actividad_imagen ai
                ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
            LEFT JOIN reserva r
                ON r.id_actividad = a.id_actividad
                AND r.estado IN ('confirmada', 'completada')
            LEFT JOIN resena res
                ON res.id_actividad = a.id_actividad
            WHERE a.estado = 'ACTIVO'
              AND p.estado = 'ACTIVO'
            GROUP BY a.id_actividad, a.nombre, a.precio, a.descripcion, a.imagen, c.nombre
            ORDER BY total_reservas DESC, promedio_calificacion DESC
            LIMIT :limite
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPublicos(string $q): array
    {
        $like = '%' . $q . '%';
        $sql = "
            SELECT
                a.id_actividad,
                a.nombre,
                a.descripcion,
                a.precio,
                a.cupos,
                a.ubicacion,
                c.nombre AS ciudad,
                COALESCE(ai.imagen, a.imagen) AS imagen
            FROM actividad a
            INNER JOIN proveedor p ON a.id_proveedor = p.id_proveedor
            INNER JOIN ciudades c ON a.id_ciudad = c.id_ciudad
            LEFT JOIN actividad_imagen ai ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
            WHERE a.estado = 'ACTIVO' AND p.estado = 'ACTIVO'
              AND (a.nombre LIKE :q1 OR a.descripcion LIKE :q2 OR c.nombre LIKE :q3)
            ORDER BY a.nombre ASC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':q1' => $like, ':q2' => $like, ':q3' => $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
