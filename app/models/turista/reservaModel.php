<?php

require_once BASE_PATH . '/config/database.php';

class ReservaModel
{
    private $db;

    public function __construct()
    {
        // Usamos TU clase conexion y TU método getConexion()
        $this->db = (new conexion())->getConexion();
    }




    public function crearReserva($data)
    {
        try {
            $sql = "INSERT INTO reserva
                (id_turista, id_actividad, fecha, cantidad_personas, precio, estado)
                VALUES
                (:id_turista, :id_actividad, :fecha, :cantidad_personas, :precio, :estado)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);

            return true;
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'ERROR PDO AL INSERTAR RESERVA:' . PHP_EOL;
            echo $e->getMessage();
            echo '</pre>';
            exit;
        }
    }




    public function obtenerPorTurista($idTurista)
    {
        $sql = "
        SELECT
            r.id_reserva,
            r.fecha,
            r.cantidad_personas,
            r.precio,
            r.estado,

            a.nombre AS nombre_actividad,

            p.nombre_empresa AS proveedor,

            ai.imagen
        FROM reserva r
        INNER JOIN actividad a 
            ON r.id_actividad = a.id_actividad
        INNER JOIN proveedor p 
            ON a.id_proveedor = p.id_proveedor
        LEFT JOIN actividad_imagen ai 
            ON ai.id_actividad = a.id_actividad 
            AND ai.es_principal = 1
        WHERE r.id_turista = :id_turista
        ORDER BY r.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_turista' => $idTurista]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerDetalleReserva($idReserva)
    {
        // Datos principales
        $sql = "
        SELECT
            r.id_reserva,
            r.fecha,
            r.cantidad_personas,
            r.precio,
            r.estado,
            a.nombre AS nombre_actividad,
            a.descripcion,
            p.nombre_empresa AS proveedor
        FROM reserva r
        INNER JOIN actividad a ON r.id_actividad = a.id_actividad
        INNER JOIN proveedor p ON a.id_proveedor = p.id_proveedor
        WHERE r.id_reserva = :id
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idReserva]);
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        // Imágenes
        $sqlImg = "
        SELECT imagen, es_principal
        FROM actividad_imagen
        WHERE id_actividad = (
            SELECT id_actividad FROM reserva WHERE id_reserva = :id
        )
        ORDER BY es_principal DESC
    ";

        $stmtImg = $this->db->prepare($sqlImg);
        $stmtImg->execute([':id' => $idReserva]);
        $imagenes = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

        $reserva['imagenes'] = $imagenes;

        return $reserva;
    }




    public function confirmar($idReserva)
    {
        $sql = "UPDATE reserva 
            SET estado = 'confirmada' 
            WHERE id_reserva = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idReserva]);
    }





    public function obtenerPorId($idReserva, $idTurista)
    {
        $sql = "SELECT * FROM reserva 
            WHERE id_reserva = :id 
            AND id_turista = :turista";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $idReserva,
            ':turista' => $idTurista
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function obtenerDetallePorId($idReserva)
    {
        $sql = "
        SELECT
            r.id_reserva,
            r.fecha,
            r.cantidad_personas,
            r.precio,
            r.estado,

            a.nombre AS nombre_actividad,
            a.descripcion,

            p.nombre_empresa AS proveedor,

            ai.imagen AS imagen_principal

        FROM reserva r
        INNER JOIN actividad a 
            ON a.id_actividad = r.id_actividad

        INNER JOIN proveedor p 
            ON p.id_proveedor = a.id_proveedor

        LEFT JOIN actividad_imagen ai 
            ON ai.id_actividad = a.id_actividad
           AND ai.es_principal = 1

        WHERE r.id_reserva = :id
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $idReserva
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    // public function actualizarEstado($idReserva, $estado)
    // {
    //     $sql = "UPDATE reserva 
    //         SET estado = :estado 
    //         WHERE id_reserva = :id";

    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute([
    //         ':estado' => $estado,
    //         ':id'     => $idReserva
    //     ]);
    // }

    // public function actualizarEstado($idReserva, $estado)
    // {
    //     $sql = "UPDATE reserva 
    //         SET estado = :estado 
    //         WHERE id_reserva = :id";

    //     $stmt = $this->db->prepare($sql);
    //     return $stmt->execute([
    //         ':estado' => $estado,
    //         ':id'     => $idReserva
    //     ]);
    // }

    public function actualizarEstado($idReserva, $estado)
    {
        $sql = "UPDATE reserva SET estado = :estado WHERE id_reserva = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id'     => $idReserva
        ]);
    }



    public function descontarCupos($idActividad, $cantidad)
    {
        $sql = "UPDATE actividad 
            SET cupos = cupos - :cantidad 
            WHERE id_actividad = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cantidad' => $cantidad,
            ':id'       => $idActividad
        ]);
    }
}
