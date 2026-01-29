<?php
require_once BASE_PATH . '/config/database.php';

class Reserva
{
    private $db;

    public function __construct()
    {
        $conexion = new conexion();
        $this->db = $conexion->getConexion();
    }



    public function crearReservaActividad($idTurista, $idActividad, $fecha, $personas)
    {
        try {
            // Iniciar transacción
            $this->db->beginTransaction();

            // 1️⃣ Insertar cabecera de la reserva
            $sqlReserva = "INSERT INTO reserva 
            (id_turista, fecha, estado, tipo_reserva, cantidad_personas)
            VALUES (:turista, :fecha, 'pendiente', 'actividad', :personas)";

            $stmtReserva = $this->db->prepare($sqlReserva);
            $stmtReserva->execute([
                ':turista'   => $idTurista,
                ':fecha'     => $fecha,
                ':personas'  => $personas
            ]);

            // Obtener el ID generado
            $idReserva = $this->db->lastInsertId();

            // 2️⃣ Insertar detalle de actividad
            $sqlDetalle = "INSERT INTO reserva_actividad 
            (id_reserva, id_actividad)
            VALUES (:reserva, :actividad)";

            $stmtDetalle = $this->db->prepare($sqlDetalle);
            $stmtDetalle->execute([
                ':reserva'   => $idReserva,
                ':actividad' => $idActividad
            ]);

            // Confirmar transacción
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Revertir si algo falla
            $this->db->rollBack();
            return false;
        }
    }


    public function obtenerReservasPorTurista($idTurista)
    {
        $sql = "SELECT *
            FROM reserva_actividad
            WHERE id_turista = :id_turista
            ORDER BY fecha_reserva DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_turista', $idTurista, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
