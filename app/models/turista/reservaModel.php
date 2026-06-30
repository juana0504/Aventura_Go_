<?php

require_once BASE_PATH . '/config/database.php';

class ReservaModel
{
    private $db;

    public function __construct()
    {
        // Usamos TU clase conexion y TU método getConexion()
        $this->db = (new conexion())->getConexion();
    }




    public function crearReserva($data)
    {
        try {
            $sql = "INSERT INTO reserva
                (id_turista, id_actividad, fecha, cantidad_personas, precio, estado)
                VALUES
                (:id_turista, :id_actividad, :fecha, :cantidad_personas, :precio, :estado)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'ERROR PDO AL INSERTAR RESERVA:' . PHP_EOL;
            echo $e->getMessage();
            echo '</pre>';
            exit;
        }
    }




    public function obtenerPorTurista($idTurista)
    {
        $sql = "
        SELECT
            r.id_reserva,
            r.fecha,
            r.cantidad_personas,
            r.precio,
            r.estado,

            a.nombre AS nombre_actividad,

            p.nombre_empresa AS proveedor,

            ai.imagen
        FROM reserva r
        INNER JOIN actividad a 
            ON r.id_actividad = a.id_actividad
        INNER JOIN proveedor p 
            ON a.id_proveedor = p.id_proveedor
        LEFT JOIN actividad_imagen ai 
            ON ai.id_actividad = a.id_actividad 
            AND ai.es_principal = 1
        WHERE r.id_turista = :id_turista
        ORDER BY r.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_turista' => $idTurista]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerDetalleReserva($idReserva)
    {
        try {
            // Paso 1: obtener fila cruda de reserva (SELECT * funciona sin importar qué columnas existan)
            $stmtBase = $this->db->prepare("SELECT * FROM reserva WHERE id_reserva = :id LIMIT 1");
            $stmtBase->execute([':id' => $idReserva]);
            $base = $stmtBase->fetch(PDO::FETCH_ASSOC);
            if (!$base) return null;

            $esHospedaje = ($base['tipo_reserva'] ?? '') === 'hospedaje';

            // Paso 2: query de detalle según tipo (solo referencias a tablas que seguro existen)
            if ($esHospedaje) {
                $sqlDetalle = "
                    SELECT r.id_reserva, r.id_turista, r.fecha, r.cantidad_personas,
                           r.precio, r.estado, r.tipo_reserva,
                           h.nombre      AS nombre_actividad,
                           h.descripcion AS descripcion,
                           ph.nombre_establecimiento AS proveedor
                    FROM reserva r
                    LEFT JOIN hospedaje h
                        ON r.id_hospedaje = h.id_hospedaje
                    LEFT JOIN proveedor_hotelero ph
                        ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
                    WHERE r.id_reserva = :id LIMIT 1";
            } else {
                $sqlDetalle = "
                    SELECT r.id_reserva, r.id_turista, r.fecha, r.cantidad_personas,
                           r.precio, r.estado, r.tipo_reserva,
                           a.nombre      AS nombre_actividad,
                           a.descripcion AS descripcion,
                           p.nombre_empresa AS proveedor
                    FROM reserva r
                    LEFT JOIN actividad a ON r.id_actividad = a.id_actividad
                    LEFT JOIN proveedor p ON a.id_proveedor = p.id_proveedor
                    WHERE r.id_reserva = :id LIMIT 1";
            }

            $stmt = $this->db->prepare($sqlDetalle);
            $stmt->execute([':id' => $idReserva]);
            $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$reserva) return null;

            // Paso 3: imágenes usando IDs ya obtenidos (sin subquery)
            try {
                if ($esHospedaje) {
                    $idHosp  = (int)($base['id_hospedaje'] ?? 0);
                    $stmtImg = $this->db->prepare(
                        "SELECT imagen, es_principal FROM hospedaje_imagen
                         WHERE id_hospedaje = :xid ORDER BY es_principal DESC"
                    );
                    $stmtImg->execute([':xid' => $idHosp]);
                } else {
                    $idAct   = (int)($base['id_actividad'] ?? 0);
                    $stmtImg = $this->db->prepare(
                        "SELECT imagen, es_principal FROM actividad_imagen
                         WHERE id_actividad = :xid ORDER BY es_principal DESC"
                    );
                    $stmtImg->execute([':xid' => $idAct]);
                }
                $reserva['imagenes'] = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log('obtenerDetalleReserva - imagenes: ' . $e->getMessage());
                $reserva['imagenes'] = [];
            }

            return $reserva;

        } catch (PDOException $e) {
            error_log('obtenerDetalleReserva: ' . $e->getMessage());
            return null;
        }
    }




    public function confirmar($idReserva)
    {
        $sql = "UPDATE reserva 
            SET estado = 'confirmada' 
            WHERE id_reserva = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idReserva]);
    }





    public function obtenerPorId($idReserva, $idTurista)
    {
        $sql = "SELECT * FROM reserva 
            WHERE id_reserva = :id 
            AND id_turista = :turista";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $idReserva,
            ':turista' => $idTurista
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function obtenerDetallePorId($idReserva)
    {
        $sql = "
        SELECT
            r.id_reserva,
            r.fecha,
            r.cantidad_personas,
            r.precio,
            r.estado,

            a.nombre AS nombre_actividad,
            a.descripcion,

            p.nombre_empresa AS proveedor,

            ai.imagen AS imagen_principal

        FROM reserva r
        INNER JOIN actividad a 
            ON a.id_actividad = r.id_actividad

        INNER JOIN proveedor p 
            ON p.id_proveedor = a.id_proveedor

        LEFT JOIN actividad_imagen ai 
            ON ai.id_actividad = a.id_actividad
           AND ai.es_principal = 1

        WHERE r.id_reserva = :id
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $idReserva
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    // public function actualizarEstado($idReserva, $estado)
    // {
    //     $sql = "UPDATE reserva 
    //         SET estado = :estado 
    //         WHERE id_reserva = :id";

    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute([
    //         ':estado' => $estado,
    //         ':id'     => $idReserva
    //     ]);
    // }

    // public function actualizarEstado($idReserva, $estado)
    // {
    //     $sql = "UPDATE reserva 
    //         SET estado = :estado 
    //         WHERE id_reserva = :id";

    //     $stmt = $this->db->prepare($sql);
    //     return $stmt->execute([
    //         ':estado' => $estado,
    //         ':id'     => $idReserva
    //     ]);
    // }

    public function actualizarEstado($idReserva, $estado)
    {
        $sql = "UPDATE reserva SET estado = :estado WHERE id_reserva = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id'     => $idReserva
        ]);
    }



    public function descontarCupos($idActividad, $cantidad)
    {
        $sql = "UPDATE actividad 
            SET cupos = cupos - :cantidad 
            WHERE id_actividad = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cantidad' => $cantidad,
            ':id'       => $idActividad
        ]);
    }
}
