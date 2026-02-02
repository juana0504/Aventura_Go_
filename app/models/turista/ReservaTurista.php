<?php
require_once __DIR__ . '/../../../config/database.php';

class ReservaTurista
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    /** Listar reservas de un turista con filtros */
    public function listarPorTurista($id_turista, $filtro = '')
    {
        $sql = "
        SELECT 
            r.id_reserva,
            r.fecha,
            r.estado,
            r.cantidad_personas,

            a.nombre AS nombre_actividad,
            a.precio,

            c.nombre AS nombre_ciudad,

            p.nombre_empresa,
            p.email_representante,

            img.imagen

             FROM reserva r
            LEFT JOIN actividad a ON r.id_actividad = a.id_actividad
            LEFT JOIN ciudades c ON a.id_ciudad = c.id_ciudad
            LEFT JOIN proveedor p ON a.id_proveedor = p.id_proveedor
            LEFT JOIN actividad_imagen img 
            ON img.id_actividad = a.id_actividad 
            AND img.es_principal = 1


        WHERE r.id_turista = :id_turista
    ";

        if ($filtro) {
            $sql .= " AND r.estado = :estado ";
        }

        $sql .= " ORDER BY r.created_at DESC ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_turista', $id_turista, PDO::PARAM_INT);

        if ($filtro) {
            $stmt->bindParam(':estado', $filtro);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Obtener detalles completos de una reserva específica
     */
    public function listarPorId($id_reserva, $id_turista)
    {
        $sql = "SELECT 
                    r.*,
                    a.nombre as nombre_actividad,
                    a.descripcion as descripcion_actividad,
                    a.ubicacion,
                    a.precio,
                    a.cupos,
                    a.imagen,
                    p.nombre_empresa,
                    p.email_representante,
                    p.telefono_representante,
                    p.direccion,
                    c.nombre as nombre_ciudad,
                    d.nombre as nombre_departamento
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                JOIN proveedor p ON a.id_proveedor = p.id_proveedor
                JOIN ciudades c ON a.id_ciudad = c.id_ciudad
                JOIN departamentos d ON c.id_departamento = d.id_departamento
                WHERE r.id_reserva = :id_reserva AND r.id_turista = :id_turista";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            $stmt->bindParam(':id_turista', $id_turista);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en listarPorId: " . $e->getMessage());
            return null;
        }
    }




    /**Verificar si una reserva pertenece al turista (seguridad) */
    public function verificarReservaDeTurista($id_reserva, $id_turista)
    {
        $sql = "SELECT id_reserva FROM reserva 
            WHERE id_reserva = :id 
              AND id_turista = :id_turista";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_reserva);
        $stmt->bindParam(':id_turista', $id_turista);
        $stmt->execute();

        return $stmt->fetch() ? true : false;
    }


    /** Cancelar reserva (solo el turista puede cancelar sus propias reservas)*/
    public function cancelarReserva($id_reserva, $id_turista)
    {
        try {
            $this->conexion->beginTransaction();

            // 1. Obtener datos de la reserva
            $sql = "SELECT id_actividad, cantidad_personas, fecha 
                FROM reserva 
                WHERE id_reserva = :id 
                  AND id_turista = :id_turista
                  AND estado = 'pendiente'
                FOR UPDATE";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id_reserva);
            $stmt->bindParam(':id_turista', $id_turista);
            $stmt->execute();

            $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$reserva) {
                $this->conexion->rollBack();
                return false;
            }

            // 2. Validar fecha (no cancelar reservas pasadas)
            if (strtotime($reserva['fecha']) < strtotime(date('Y-m-d'))) {
                $this->conexion->rollBack();
                return false;
            }

            // 3. Cancelar reserva
            $sql = "UPDATE reserva 
                SET estado = 'cancelada' 
                WHERE id_reserva = :id";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id_reserva);
            $stmt->execute();

            // 4. Reintegrar cupos
            $sql = "UPDATE actividad 
                SET cupos = cupos + :personas 
                WHERE id_actividad = :id_actividad";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':personas', $reserva['cantidad_personas']);
            $stmt->bindParam(':id_actividad', $reserva['id_actividad']);
            $stmt->execute();

            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollBack();
            return false;
        }
    }




    /**
     * Listar reservas para generación de PDF
     */
    public function listarParaPdf($id_turista, $filtro = '')
    {
        return $this->listarPorTurista($id_turista, $filtro);
    }




    /**
     * Obtener estadísticas del turista
     */
    public function obtenerEstadisticas($id_turista)
    {
        $sql = "SELECT 
                    COUNT(*) as total_reservas,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN estado = 'confirmada' THEN 1 ELSE 0 END) as confirmadas,
                    SUM(CASE WHEN estado = 'cancelada' THEN 1 ELSE 0 END) as canceladas,
                    SUM(CASE WHEN estado = 'completada' THEN 1 ELSE 0 END) as completadas,
                    SUM(r.cantidad_personas * a.precio) as total_invertido,
                    COUNT(DISTINCT a.id_proveedor) as proveedores_diferentes
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                WHERE r.id_turista = :id_turista";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_turista', $id_turista);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerEstadisticas: " . $e->getMessage());
            return null;
        }
    }





    /**
     * Obtener actividades populares para el turista
     */
    public function obtenerActividadesPopulares($id_turista)
    {
        $sql = "SELECT 
                    a.nombre_actividad,
                    COUNT(*) as veces_reservada
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                WHERE r.id_turista = :id_turista
                GROUP BY a.id_actividad, a.nombre
                ORDER BY veces_reservada DESC
                LIMIT 5";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_turista', $id_turista);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerActividadesPopulares: " . $e->getMessage());
            return [];
        }
    }






    public function crearReserva($data)
    {
        $sql = "INSERT INTO reserva (
                    id_turista,
                    id_actividad,
                    fecha,
                    cantidad_personas,
                    precio,
                    estado,
                    tipo_reserva
                ) VALUES (
                    :id_turista,
                    :id_actividad,
                    :fecha,
                    :cantidad_personas,
                    :precio,
                    :estado,
                    :tipo_reserva
                )";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_turista'        => $data['id_turista'],
            ':id_actividad'     => $data['id_actividad'],
            ':fecha'            => $data['fecha'],
            ':cantidad_personas' => $data['cantidad_personas'],
            ':precio'           => $data['precio'],
            ':estado'           => $data['estado'],
            ':tipo_reserva'     => $data['tipo_reserva']
        ]);
    }





    public function confirmarReserva($id_reserva, $id_turista)
    {
        $sql = "
        UPDATE reserva 
        SET estado = 'confirmada'
        WHERE id_reserva = :id
          AND id_turista = :id_turista
          AND estado = 'pendiente'
    ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_reserva, PDO::PARAM_INT);
        $stmt->bindParam(':id_turista', $id_turista, PDO::PARAM_INT);
        return $stmt->execute();
    }



    public function obtenerReservaPorId($id_reserva)
    {
        $sql = "SELECT * FROM reserva WHERE id_reserva = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_reserva, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
