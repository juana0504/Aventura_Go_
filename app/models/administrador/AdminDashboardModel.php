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
        return [];
    }
}
