<?php
require_once __DIR__ . '/../../../config/database.php';

class AdminDashboardModel {
    private $conexion;

    public function __construct() {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    public function getTotalReservas() {
        $stmt = $this->conexion->query("SELECT COUNT(*) FROM reserva");
        return (int) $stmt->fetchColumn();
    }

    public function getReservasDiarias() {
        $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM reserva WHERE DATE(fecha) = CURDATE()");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function getExperienciasActivas() {
        $stmt = $this->conexion->query("SELECT COUNT(*) FROM actividad WHERE estado = 'ACTIVO'");
        return (int) $stmt->fetchColumn();
    }

    public function getIngresosDisponibles() {
        $stmt = $this->conexion->query("SELECT SUM(monto) FROM pago");
        $sum = $stmt->fetchColumn();
        return $sum !== null ? (float) $sum : 0;
    }

    public function getUltimaReserva() {
        $stmt = $this->conexion->query(
            "SELECT r.id_reserva, u.nombre AS cliente, r.fecha, r.precio, a.nombre AS experiencia
             FROM reserva r
             JOIN usuario u ON r.id_turista = u.id_usuario
             JOIN actividad a ON r.id_actividad = a.id_actividad
             ORDER BY r.id_reserva DESC LIMIT 1"
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ejemplo: devuelve listas para gráfico de reservas últimos $dias días
    public function getReservasPorDia($dias = 7) {
        $query = "SELECT DATE(fecha) AS dia, COUNT(*) AS total
                  FROM reserva
                  WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL :dias DAY)
                  GROUP BY DATE(fecha)";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([':dias' => $dias]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGastosPorCategoria() {
        // placeholder: en este esquema no hay gastos separados, devolvemos un array vacío
        // en el futuro podría construirse desde una tabla de transacciones
        return [];
    }

    /**
     * Obtiene las reservas más recientes, ordenadas por fecha.
     * Devuelve array con cliente, fecha, precio y experiencia.
     */
    public function getReservasRecientes($limit = 10) {
        $query = "SELECT r.id_reserva, u.nombre AS cliente, r.fecha, r.precio, a.nombre AS experiencia
                  FROM reserva r
                  JOIN usuario u ON r.id_turista = u.id_usuario
                  JOIN actividad a ON r.id_actividad = a.id_actividad
                  ORDER BY r.fecha DESC
                  LIMIT :limit";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInversionPublicidad() {
        // asumimos que los pagos relacionados con publicidad se distinguen
        // por el método de pago que contenga la palabra "publicidad".
        $stmt = $this->conexion->prepare(
            "SELECT SUM(monto) FROM pago WHERE LOWER(metodo_pago) LIKE '%publicidad%'"
        );
        $stmt->execute();
        $sum = $stmt->fetchColumn();
        return $sum !== null ? (float) $sum : 0.0;
    }

    /**
     * Obtiene los próximos pagos pendientes (hasta 3) ordenados por fecha.
     * Devuelve arreglo con 'texto' y 'cantidad'.
     */
    public function getProximosPagos() {
        $stmt = $this->conexion->prepare(
            "SELECT metodo_pago AS texto, monto AS cantidad
             FROM pago
             WHERE estado IS NULL OR estado <> 'pagado'
             ORDER BY fecha ASC
             LIMIT 3"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) {
            return [];
        }
        return $rows;
    }
}
