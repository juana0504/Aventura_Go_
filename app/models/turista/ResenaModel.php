<?php

require_once BASE_PATH . '/config/database.php';

class ResenaModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new conexion())->getConexion();
    }

    // Reservas confirmadas del turista que aún no tienen reseña
    public function obtenerReservasPendientesDeReseña($idTurista)
    {
        $sql = "
            SELECT
                r.id_reserva,
                r.fecha,
                r.cantidad_personas,
                r.precio,
                a.id_actividad,
                a.nombre AS nombre_actividad,
                p.nombre_empresa AS proveedor,
                ai.imagen
            FROM reserva r
            INNER JOIN actividad a ON r.id_actividad = a.id_actividad
            INNER JOIN proveedor p ON a.id_proveedor = p.id_proveedor
            LEFT JOIN actividad_imagen ai
                ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
            WHERE r.id_turista = :id_turista
              AND r.estado = 'confirmada'
              AND r.id_reserva NOT IN (
                  SELECT id_reserva FROM resena WHERE id_usuario = :id_usuario
              )
            ORDER BY r.fecha DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_turista' => $idTurista, ':id_usuario' => $idTurista]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Reseñas ya dejadas por el turista
    public function obtenerResenasPorTurista($idUsuario)
    {
        $sql = "
            SELECT
                res.id_resena,
                res.calificacion,
                res.comentario,
                res.fecha,
                a.nombre AS nombre_actividad,
                p.nombre_empresa AS proveedor,
                ai.imagen
            FROM resena res
            INNER JOIN actividad a ON res.id_actividad = a.id_actividad
            INNER JOIN proveedor p ON a.id_proveedor = p.id_proveedor
            LEFT JOIN actividad_imagen ai
                ON ai.id_actividad = a.id_actividad AND ai.es_principal = 1
            WHERE res.id_usuario = :id_usuario
            ORDER BY res.fecha DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar que la reserva pertenece al turista y está confirmada
    public function reservaValida($idReserva, $idTurista)
    {
        $sql = "SELECT id_reserva, id_actividad FROM reserva
                WHERE id_reserva = :id_reserva
                  AND id_turista = :id_turista
                  AND estado = 'confirmada'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_reserva' => $idReserva, ':id_turista' => $idTurista]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Guardar reseña
    public function guardar($idUsuario, $idReserva, $idActividad, $calificacion, $comentario)
    {
        $sql = "INSERT INTO resena (id_usuario, id_reserva, id_actividad, calificacion, comentario)
                VALUES (:id_usuario, :id_reserva, :id_actividad, :calificacion, :comentario)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_usuario'   => $idUsuario,
            ':id_reserva'   => $idReserva,
            ':id_actividad' => $idActividad,
            ':calificacion' => $calificacion,
            ':comentario'   => $comentario,
        ]);
    }
}
