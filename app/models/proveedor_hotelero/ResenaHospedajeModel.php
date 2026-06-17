<?php
require_once BASE_PATH . '/config/database.php';

class ResenaHospedajeModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new conexion())->getConexion();
    }

    public function obtenerPorHospedaje($id_hospedaje)
    {
        try {
            $sql = "SELECT
                        rh.calificacion,
                        rh.comentario,
                        rh.created_at AS fecha,
                        u.nombre AS nombre_turista
                    FROM resena_hospedaje rh
                    LEFT JOIN usuario u ON rh.id_usuario = u.id_usuario
                    WHERE rh.id_hospedaje = :id_hospedaje
                    ORDER BY rh.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_hospedaje' => $id_hospedaje]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ResenaHospedajeModel::obtenerPorHospedaje: " . $e->getMessage());
            return [];
        }
    }

    public function guardar($id_hospedaje, $id_usuario, $calificacion, $comentario, $id_reserva = null)
    {
        try {
            $sql = "INSERT INTO resena_hospedaje
                        (id_hospedaje, id_reserva, id_usuario, calificacion, comentario)
                    VALUES
                        (:id_hospedaje, :id_reserva, :id_usuario, :calificacion, :comentario)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':id_hospedaje'  => $id_hospedaje,
                ':id_reserva'    => $id_reserva,
                ':id_usuario'    => $id_usuario,
                ':calificacion'  => $calificacion,
                ':comentario'    => $comentario,
            ]);
        } catch (PDOException $e) {
            error_log("ResenaHospedajeModel::guardar: " . $e->getMessage());
            return false;
        }
    }
}
