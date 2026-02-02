<!-- albert paso 2 para reserva -->
<?php
require_once __DIR__ . '/../../helpers/session_turista.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/turista/ReservaTurista.php';

class ActividadModel
{
    private $db;

    public function __construct()
    {
        require_once BASE_PATH . '/config/database.php';
        $this->db = (new conexion())->getConexion();
    }

    public function obtenerPorId($idActividad)
    {
        $sql = "SELECT a.*, c.nombre AS ciudad
                FROM actividad a
                LEFT JOIN ciudades c ON c.id_ciudad = a.id_ciudad
                WHERE a.id_actividad = :id AND a.estado = 'ACTIVO'";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $idActividad, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function descontarCupos($idActividad, $cantidad)
    {
        $sql = "UPDATE actividad
                SET cupos = cupos - :cantidad
                WHERE id_actividad = :id AND cupos >= :cantidad";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cantidad' => $cantidad,
            ':id' => $idActividad
        ]);
    }

    public function devolverCupos($idActividad, $cantidad)
    {
        $sql = "UPDATE actividad
                SET cupos = cupos + :cantidad
                WHERE id_actividad = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cantidad' => $cantidad,
            ':id' => $idActividad
        ]);
    }
}
