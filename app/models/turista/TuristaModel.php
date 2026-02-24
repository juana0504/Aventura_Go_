<?php
require_once __DIR__ . '/../../../config/database.php';

class TuristaModel {

    private $conexion;

    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    public function getDashboardDataByUserId($id_usuario) {
        // aseguramos que exista un perfil de turista en la tabla
        $this->ensureTouristForUser($id_usuario);

        // Obtener el id_turista desde la tabla turista
        // traemos también el id_turista para las consultas posteriores
        $query = "SELECT u.nombre AS nombre, t.id_turista, t.preferencias
              FROM usuario u
              JOIN turista t ON u.id_usuario = t.id_usuario
              WHERE u.id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([':id_usuario' => $id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            // en teoría no puede ocurrir thanks a ensureTouristForUser,
            // pero mantenemos compatibilidad con versiones anteriores.
            return null;
        }

        $id_turista = $row['id_turista'];
        $actividades = $id_turista ? $this->getActividades($id_turista) : [];
        $lugares = $id_turista ? $this->getLugaresVisitados($id_turista) : [];

        return [
            'nombre' => $row['nombre'],
            'preferencias' => $row['preferencias'],
            'actividades' => $actividades,
            'lugares_visitados' => $lugares
        ];
    }

    private function getActividades($id_turista) {
        // La base de datos no tiene una tabla "actividades" con turista_id.
        // En su lugar usamos las reservas hechas por el turista para obtener
        // los nombres de las actividades y cuántas veces las ha reservado.
        try {
            $query = "SELECT a.nombre AS actividad, r.fecha, COUNT(r.id_reserva) AS veces
                      FROM reserva r
                      JOIN actividad a ON r.id_actividad = a.id_actividad
                      WHERE r.id_turista = :id_turista
                      GROUP BY a.nombre, r.fecha";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([':id_turista' => $id_turista]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // si algo falla devolvemos arreglo vacío para no romper el dashboard
            error_log("[TuristaModel] getActividades error: " . $e->getMessage());
            return [];
        }
    }

    private function getLugaresVisitados($id_turista) {
        // No hay tabla 'lugares_visitados'; tomamos la ubicación de la actividad
        // como 'lugar' y contamos reservas por ubicación.
        try {
            $query = "SELECT a.ubicacion AS lugar, COUNT(r.id_reserva) AS visitas
                      FROM reserva r
                      JOIN actividad a ON r.id_actividad = a.id_actividad
                      WHERE r.id_turista = :id_turista
                      GROUP BY a.ubicacion";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([':id_turista' => $id_turista]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("[TuristaModel] getLugaresVisitados error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Inserta un registro de turista si el usuario no tiene uno.
     * Esto evita errores cuando se accede al dashboard sin perfil creado.
     */
    private function ensureTouristForUser($id_usuario) {
        $check = $this->conexion->prepare("SELECT id_turista FROM turista WHERE id_usuario = :id_usuario");
        $check->execute([':id_usuario' => $id_usuario]);
        if ($check->fetchColumn() === false) {
            $insert = $this->conexion->prepare("INSERT INTO turista (id_usuario, preferencias) VALUES (:id_usuario, '')");
            $insert->execute([':id_usuario' => $id_usuario]);
        }
    }
}
