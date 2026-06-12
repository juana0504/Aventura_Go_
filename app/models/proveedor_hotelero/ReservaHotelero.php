<?php
require_once __DIR__ . '/../../../config/database.php';

class ReservaHotelero
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new conexion())->getConexion();
    }

    public function listarPorProveedor($id_proveedor_hotelero, $filtro = '')
    {
        $sql = "SELECT
                    r.id_reserva,
                    r.fecha,
                    r.estado,
                    r.cantidad_personas,
                    r.created_at AS fecha_reserva,
                    h.nombre AS nombre_hospedaje,
                    h.precio,
                    h.ubicacion,
                    u.nombre AS nombre_turista,
                    u.email  AS email_turista,
                    u.telefono AS telefono_turista
                FROM reserva r
                JOIN hospedaje h ON r.id_hospedaje = h.id_hospedaje
                LEFT JOIN usuario u ON r.id_turista = u.id_usuario
                WHERE h.id_proveedor_hotelero = :id_proveedor_hotelero";

        if ($filtro && $filtro !== 'all') {
            $sql .= " AND r.estado = :estado";
        }

        $sql .= " ORDER BY r.created_at DESC";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor_hotelero', $id_proveedor_hotelero);
            if ($filtro && $filtro !== 'all') {
                $stmt->bindParam(':estado', $filtro);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ReservaHotelero::listarPorProveedor: " . $e->getMessage());
            return [];
        }
    }

    public function listarPorId($id_reserva)
    {
        $sql = "SELECT
                    r.*,
                    h.nombre   AS nombre_hospedaje,
                    h.descripcion AS descripcion_hospedaje,
                    h.ubicacion,
                    h.precio,
                    h.capacidad,
                    u.nombre   AS nombre_turista,
                    u.email    AS email_turista,
                    u.telefono AS telefono_turista,
                    ph.nombre_establecimiento AS nombre_empresa
                FROM reserva r
                JOIN hospedaje h ON r.id_hospedaje = h.id_hospedaje
                LEFT JOIN usuario u ON r.id_turista = u.id_usuario
                JOIN proveedor_hotelero ph ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
                WHERE r.id_reserva = :id_reserva";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ReservaHotelero::listarPorId: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerEstadisticas($id_proveedor_hotelero)
    {
        $sql = "SELECT
                    COUNT(*)  AS total,
                    SUM(CASE WHEN r.estado = 'pendiente'  THEN 1 ELSE 0 END) AS pendientes,
                    SUM(CASE WHEN r.estado = 'confirmada' THEN 1 ELSE 0 END) AS confirmadas,
                    SUM(CASE WHEN r.estado = 'cancelada'  THEN 1 ELSE 0 END) AS canceladas,
                    SUM(r.cantidad_personas * h.precio) AS ingresos_potenciales
                FROM reserva r
                JOIN hospedaje h ON r.id_hospedaje = h.id_hospedaje
                WHERE h.id_proveedor_hotelero = :id_proveedor_hotelero";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor_hotelero', $id_proveedor_hotelero);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ReservaHotelero::obtenerEstadisticas: " . $e->getMessage());
            return [];
        }
    }

    public function listarParaPdf($id_proveedor_hotelero, $filtro = '')
    {
        return $this->listarPorProveedor($id_proveedor_hotelero, $filtro);
    }

    public function verificarReservaDeProveedor($id_reserva, $id_proveedor_hotelero)
    {
        $sql = "SELECT r.id_reserva FROM reserva r
                JOIN hospedaje h ON r.id_hospedaje = h.id_hospedaje
                WHERE r.id_reserva = :id_reserva
                AND h.id_proveedor_hotelero = :id_proveedor_hotelero";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->bindParam(':id_proveedor_hotelero', $id_proveedor_hotelero);
        $stmt->execute();
        return $stmt->fetch() ? true : false;
    }

    public function confirmarReserva($id_reserva)
    {
        $sql  = "UPDATE reserva SET estado = 'confirmada' WHERE id_reserva = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_reserva);
        return $stmt->execute();
    }

    public function cancelarReserva($id_reserva)
    {
        $sql  = "UPDATE reserva SET estado = 'cancelada' WHERE id_reserva = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id_reserva);
        return $stmt->execute();
    }

    public function obtenerRecentesParaDashboard($id_proveedor_hotelero, $limit = 10)
    {
        $sql = "SELECT
                    r.id_reserva,
                    r.fecha,
                    r.estado,
                    r.cantidad_personas,
                    h.nombre AS nombre_hospedaje,
                    h.precio,
                    u.nombre AS nombre_turista
                FROM reserva r
                JOIN hospedaje h ON r.id_hospedaje = h.id_hospedaje
                LEFT JOIN usuario u ON r.id_turista = u.id_usuario
                WHERE h.id_proveedor_hotelero = :id_proveedor_hotelero
                ORDER BY r.created_at DESC
                LIMIT :lim";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor_hotelero', $id_proveedor_hotelero);
            $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ReservaHotelero::obtenerRecentesParaDashboard: " . $e->getMessage());
            return [];
        }
    }
}
