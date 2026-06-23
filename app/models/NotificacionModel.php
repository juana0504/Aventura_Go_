<?php
require_once __DIR__ . '/../../config/database.php';

class NotificacionModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Conexion())->getConexion();
    }

    public function crear(int $id_usuario, string $origen, string $titulo, string $mensaje,
                          string $icono = 'bi-bell-fill', string $color = 'blue',
                          ?string $url_destino = null, ?int $referencia_id = null): bool
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO notificaciones
                (id_usuario, origen, titulo, mensaje, icono, color, url_destino, referencia_id)
             VALUES
                (:id_usuario, :origen, :titulo, :mensaje, :icono, :color, :url_destino, :referencia_id)"
        );
        return $stmt->execute([
            ':id_usuario'    => $id_usuario,
            ':origen'        => $origen,
            ':titulo'        => $titulo,
            ':mensaje'       => $mensaje,
            ':icono'         => $icono,
            ':color'         => $color,
            ':url_destino'   => $url_destino,
            ':referencia_id' => $referencia_id,
        ]);
    }

    public function listarActivas(int $id_usuario, int $limit = 15): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM notificaciones
             WHERE id_usuario = :id AND archivada = 0 AND activo = 1
             ORDER BY fecha_evento DESC
             LIMIT :limit"
        );
        $stmt->bindParam(':id',    $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit,      PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarNoLeidas(int $id_usuario): int
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM notificaciones
             WHERE id_usuario = :id AND leida = 0 AND archivada = 0 AND activo = 1"
        );
        $stmt->execute([':id' => $id_usuario]);
        return (int)$stmt->fetchColumn();
    }

    public function marcarLeida(int $id_notificacion, int $id_usuario): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE notificaciones SET leida = 1
             WHERE id_notificacion = :id AND id_usuario = :id_usuario"
        );
        return $stmt->execute([':id' => $id_notificacion, ':id_usuario' => $id_usuario]);
    }

    public function marcarTodasLeidas(int $id_usuario): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE notificaciones SET leida = 1
             WHERE id_usuario = :id AND leida = 0 AND archivada = 0"
        );
        return $stmt->execute([':id' => $id_usuario]);
    }

    public function archivar(int $id_notificacion, int $id_usuario): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE notificaciones SET archivada = 1
             WHERE id_notificacion = :id AND id_usuario = :id_usuario"
        );
        return $stmt->execute([':id' => $id_notificacion, ':id_usuario' => $id_usuario]);
    }
}
