<?php
require_once __DIR__ . '/../../../config/database.php';

class Reserva {
    private $conexion;
    
    public function __construct() {
        $this->conexion = (new Conexion())->getConexion();
    }
    
    /**
     * Listar reservas de un proveedor con filtros
     */
    public function listarPorProveedor($id_proveedor, $filtro = '') {
        $sql = "SELECT 
                    r.id_reserva,
                    r.fecha,
                    r.estado,
                    r.cantidad_personas,
                    r.created_at as fecha_reserva,
                    a.nombre as nombre_actividad,
                    a.precio,
                    a.ubicacion,
                    u.nombre as nombre_turista,
                    u.email as email_turista,
                    u.telefono as telefono_turista
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                JOIN usuario u ON r.id_turista = u.id_usuario
                WHERE a.id_proveedor = :id_proveedor";
        
        if ($filtro && $filtro !== 'all') {
            $sql .= " AND r.estado = :estado";
        }
        
        $sql .= " ORDER BY r.created_at DESC";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor', $id_proveedor);
            
            if ($filtro && $filtro !== 'all') {
                $stmt->bindParam(':estado', $filtro);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en listarPorProveedor: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener detalles completos de una reserva específica
     */
    public function listarPorId($id_reserva) {
        $sql = "SELECT 
                    r.*,
                    a.nombre as nombre_actividad,
                    a.descripcion as descripcion_actividad,
                    a.ubicacion,
                    a.precio,
                    a.cupos,
                    u.nombre as nombre_turista,
                    u.email as email_turista,
                    u.telefono as telefono_turista,
                    p.nombre_empresa,
                    p.email_representante
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                JOIN usuario u ON r.id_turista = u.id_usuario
                JOIN proveedor p ON a.id_proveedor = p.id_proveedor
                WHERE r.id_reserva = :id_reserva";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en listarPorId: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Confirmar una reserva (cambiar estado a 'confirmada')
     */
    public function confirmarReserva($id_reserva) {
        $sql = "UPDATE reserva SET estado = 'confirmada', modified_at = NOW() 
                WHERE id_reserva = :id_reserva";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error en confirmarReserva: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Cancelar una reserva (cambiar estado a 'cancelada')
     */
    public function cancelarReserva($id_reserva) {
        $sql = "UPDATE reserva SET estado = 'cancelada', modified_at = NOW() 
                WHERE id_reserva = :id_reserva";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error en cancelarReserva: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Listar reservas para generación de PDF (método especializado)
     */
    public function listarParaPdf($id_proveedor, $filtro = '') {
        return $this->listarPorProveedor($id_proveedor, $filtro);
    }
    
    /**
     * Verificar si una reserva pertenece al proveedor actual (seguridad)
     */
    public function verificarReservaDeProveedor($id_reserva, $id_proveedor) {
        $sql = "SELECT COUNT(*) as count 
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                WHERE r.id_reserva = :id_reserva AND a.id_proveedor = :id_proveedor";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva);
            $stmt->bindParam(':id_proveedor', $id_proveedor);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
            
        } catch (PDOException $e) {
            error_log("Error en verificarReservaDeProveedor: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener estadísticas de reservas para el proveedor
     */
    public function obtenerEstadisticas($id_proveedor) {
        $sql = "SELECT 
                    COUNT(*) as total_reservas,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN estado = 'confirmada' THEN 1 ELSE 0 END) as confirmadas,
                    SUM(CASE WHEN estado = 'cancelada' THEN 1 ELSE 0 END) as canceladas,
                    SUM(r.cantidad_personas * a.precio) as ingresos_potenciales
                FROM reserva r
                JOIN reserva_actividad ra ON r.id_reserva = ra.id_reserva
                JOIN actividad a ON ra.id_actividad = a.id_actividad
                WHERE a.id_proveedor = :id_proveedor";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_proveedor', $id_proveedor);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en obtenerEstadisticas: " . $e->getMessage());
            return null;
        }
    }
}
?>