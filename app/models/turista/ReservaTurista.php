<?php
require_once __DIR__ . '/../../../config/database.php';

class ReservaTurista {
    private $conexion;
    
    public function __construct() {
        $this->conexion = (new Conexion())->getConexion();
    }
    
    /**
     * Listar reservas de un turista con filtros
     */
    public function listarPorTurista($id_turista, $filtro = '') {
        $sql = "SELECT 
                    r.id_reserva,
                    r.fecha,
                    r.estado,
                    r.cantidad_personas,
                    r.created_at as fecha_reserva,
                    a.nombre as nombre_actividad,
                    a.descripcion,
                    a.precio,
                    a.ubicacion,
                    a.cupos,
                    p.nombre_empresa,
                    p.email_representante,
                    p.telefono_representante,
                    c.nombre as nombre_ciudad
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                JOIN proveedor p ON a.id_proveedor = p.id_proveedor
                JOIN ciudades c ON a.id_ciudad = c.id_ciudad
                WHERE r.id_turista = :id_turista";
        
        if ($filtro && $filtro !== 'all') {
            $sql .= " AND r.estado = :estado";
        }
        
        $sql .= " ORDER BY r.created_at DESC";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_turista', $id_turista);
            
            if ($filtro && $filtro !== 'all') {
                $stmt->bindParam(':estado', $filtro);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en listarPorTurista: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener detalles completos de una reserva específica
     */
    public function listarPorId($id_reserva, $id_turista) {
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
    
    /**
     * Verificar si una reserva pertenece al turista (seguridad)
     */
    public function verificarReservaDeTurista($id_reserva, $id_turista) {
        $sql = "SELECT COUNT(*) as count 
                FROM reserva 
                WHERE id_reserva = :id_reserva AND id_turista = :id_turista";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            $stmt->bindParam(':id_turista', $id_turista);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
            
        } catch (PDOException $e) {
            error_log("Error en verificarReservaDeTurista: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Cancelar reserva (solo el turista puede cancelar sus propias reservas)
     */
    public function cancelarReserva($id_reserva, $id_turista) {
        $sql = "UPDATE reserva SET estado = 'cancelada', modified_at = NOW() 
                WHERE id_reserva = :id_reserva AND id_turista = :id_turista";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            $stmt->bindParam(':id_turista', $id_turista);
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error en cancelarReserva: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Listar reservas para generación de PDF
     */
    public function listarParaPdf($id_turista, $filtro = '') {
        return $this->listarPorTurista($id_turista, $filtro);
    }
    
    /**
     * Obtener estadísticas del turista
     */
    public function obtenerEstadisticas($id_turista) {
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
    public function obtenerActividadesPopulares($id_turista) {
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
}
?>