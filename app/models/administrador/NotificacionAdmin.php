<?php

require_once BASE_PATH . '/config/database.php';

class NotificacionAdmin
{
    private PDO $conexion;

    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    private function asegurarTablas(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS notificaciones (
                id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
                origen VARCHAR(60) NOT NULL,
                referencia_id INT NULL,
                titulo VARCHAR(180) NOT NULL,
                mensaje VARCHAR(255) NOT NULL,
                icono VARCHAR(60) NOT NULL DEFAULT 'bi-bell-fill',
                color VARCHAR(20) NOT NULL DEFAULT 'blue',
                url_destino VARCHAR(255) NULL,
                fecha_evento DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                activo TINYINT(1) NOT NULL DEFAULT 1,
                UNIQUE KEY uk_noti_origen_ref (origen, referencia_id),
                KEY idx_noti_evento (fecha_evento),
                KEY idx_noti_activo (activo)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $this->conexion->exec($sql);

        $sql = "
            CREATE TABLE IF NOT EXISTS admin_notificacion_estado (
                id_estado INT AUTO_INCREMENT PRIMARY KEY,
                id_admin INT NOT NULL,
                id_notificacion INT NOT NULL,
                leida TINYINT(1) NOT NULL DEFAULT 0,
                fecha_lectura DATETIME NULL,
                fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY uk_admin_noti (id_admin, id_notificacion),
                KEY idx_admin_no_leidas (id_admin, leida)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        $this->conexion->exec($sql);
    }

    private function sincronizarFuentes(int $idAdmin): void
    {
        $this->asegurarTablas();

        $sql = "
            INSERT INTO notificaciones (
                origen,
                referencia_id,
                titulo,
                mensaje,
                icono,
                color,
                url_destino,
                fecha_evento,
                activo
            )
            SELECT
                'ticket_abierto',
                t.id_ticket,
                CONCAT('Ticket #', t.id_ticket),
                CONCAT(COALESCE(t.asunto, 'Ticket de soporte'), ' (', COALESCE(u.nombre, 'Usuario'), ').'),
                'bi-ticket-perforated-fill',
                'amber',
                CONCAT('administrador/tickets/responder?id=', t.id_ticket),
                t.fecha_creacion,
                1
            FROM tickets t
            LEFT JOIN usuario u ON u.id_usuario = t.id_usuario
            WHERE t.estado = 'abierto'
            ON DUPLICATE KEY UPDATE
                titulo = VALUES(titulo),
                mensaje = VALUES(mensaje),
                icono = VALUES(icono),
                color = VALUES(color),
                url_destino = VALUES(url_destino),
                fecha_evento = VALUES(fecha_evento),
                activo = 1
        ";

        $this->conexion->exec($sql);

        $sql = "
            INSERT INTO notificaciones (
                origen,
                referencia_id,
                titulo,
                mensaje,
                icono,
                color,
                url_destino,
                fecha_evento,
                activo
            )
            SELECT
                'turista_nuevo',
                u.id_usuario,
                'Nuevo turista registrado',
                CONCAT(COALESCE(u.nombre, 'Turista sin nombre'), ' se registro en la plataforma.'),
                'bi-person-plus-fill',
                'blue',
                'administrador/consultar-turista',
                NOW(),
                1
            FROM usuario u
            WHERE LOWER(COALESCE(u.rol, '')) = 'turista'
            ON DUPLICATE KEY UPDATE
                titulo = VALUES(titulo),
                mensaje = VALUES(mensaje),
                icono = VALUES(icono),
                color = VALUES(color),
                url_destino = VALUES(url_destino),
                activo = 1
        ";

        $this->conexion->exec($sql);

        $sql = "
            INSERT INTO notificaciones (
                origen,
                referencia_id,
                titulo,
                mensaje,
                icono,
                color,
                url_destino,
                fecha_evento,
                activo
            )
            SELECT
                'proveedor_turistico_pendiente',
                p.id_proveedor,
                'Proveedor turistico pendiente',
                CONCAT(
                    COALESCE(p.nombre_empresa, u.nombre, 'Proveedor sin nombre'),
                    ' pendiente de aprobacion.'
                ),
                'bi-person-plus-fill',
                'amber',
                'administrador/consultar-proveedor',
                NOW(),
                1
            FROM proveedor p
            LEFT JOIN usuario u ON u.id_usuario = p.id_usuario
            WHERE (
                UPPER(COALESCE(p.estado, '')) IN ('PENDIENTE', 'EN_REVISION')
                OR COALESCE(p.validado, 0) = 0
            )
            ON DUPLICATE KEY UPDATE
                titulo = VALUES(titulo),
                mensaje = VALUES(mensaje),
                icono = VALUES(icono),
                color = VALUES(color),
                url_destino = VALUES(url_destino),
                activo = 1
        ";

        $this->conexion->exec($sql);

        $sql = "
            INSERT INTO notificaciones (
                origen,
                referencia_id,
                titulo,
                mensaje,
                icono,
                color,
                url_destino,
                fecha_evento,
                activo
            )
            SELECT
                'proveedor_hotelero_pendiente',
                ph.id_proveedor_hotelero,
                'Proveedor hotelero pendiente',
                CONCAT(
                    COALESCE(ph.nombre_establecimiento, u.nombre, 'Hotel sin nombre'),
                    ' pendiente de aprobacion.'
                ),
                'bi-building-fill-add',
                'amber',
                'administrador/consultar-proveedor-hotelero',
                NOW(),
                1
            FROM proveedor_hotelero ph
            LEFT JOIN usuario u ON u.id_usuario = ph.id_usuario
            WHERE (
                UPPER(COALESCE(ph.estado, '')) IN ('PENDIENTE', 'EN_REVISION')
                OR COALESCE(ph.validado, 0) = 0
            )
            ON DUPLICATE KEY UPDATE
                titulo = VALUES(titulo),
                mensaje = VALUES(mensaje),
                icono = VALUES(icono),
                color = VALUES(color),
                url_destino = VALUES(url_destino),
                activo = 1
        ";

        $this->conexion->exec($sql);

        $sql = "
            UPDATE notificaciones n
            LEFT JOIN tickets t ON t.id_ticket = n.referencia_id
            SET n.activo = CASE
                WHEN t.id_ticket IS NOT NULL AND t.estado = 'abierto' THEN 1
                ELSE 0
            END
            WHERE n.origen = 'ticket_abierto'
        ";

        $this->conexion->exec($sql);

        $sql = "
            UPDATE notificaciones n
            LEFT JOIN proveedor p ON p.id_proveedor = n.referencia_id
            SET n.activo = CASE
                WHEN p.id_proveedor IS NOT NULL
                     AND (
                        UPPER(COALESCE(p.estado, '')) IN ('PENDIENTE', 'EN_REVISION')
                        OR COALESCE(p.validado, 0) = 0
                     ) THEN 1
                ELSE 0
            END
            WHERE n.origen = 'proveedor_turistico_pendiente'
        ";

        $this->conexion->exec($sql);

        $sql = "
            UPDATE notificaciones n
            LEFT JOIN proveedor_hotelero ph ON ph.id_proveedor_hotelero = n.referencia_id
            SET n.activo = CASE
                WHEN ph.id_proveedor_hotelero IS NOT NULL
                     AND (
                        UPPER(COALESCE(ph.estado, '')) IN ('PENDIENTE', 'EN_REVISION')
                        OR COALESCE(ph.validado, 0) = 0
                     ) THEN 1
                ELSE 0
            END
            WHERE n.origen = 'proveedor_hotelero_pendiente'
        ";

        $this->conexion->exec($sql);

        $sql = "
            UPDATE notificaciones n
            LEFT JOIN usuario u ON u.id_usuario = n.referencia_id
            SET n.activo = CASE
                WHEN u.id_usuario IS NOT NULL
                     AND LOWER(COALESCE(u.rol, '')) = 'turista' THEN 1
                ELSE 0
            END
            WHERE n.origen = 'turista_nuevo'
        ";

        $this->conexion->exec($sql);

        $sql = "
            INSERT IGNORE INTO admin_notificacion_estado (id_admin, id_notificacion)
            SELECT :id_admin, n.id_notificacion
            FROM notificaciones n
            WHERE n.activo = 1
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id_admin', $idAdmin, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function listar(int $idAdmin, int $limite = 6): array
    {
        $limite = max(1, min($limite, 20));
        $this->sincronizarFuentes($idAdmin);

        $sql = "
            SELECT
                n.id_notificacion,
                n.titulo,
                n.mensaje,
                n.icono,
                n.color,
                n.url_destino,
                n.fecha_evento,
                COALESCE(a.leida, 0) AS leida
            FROM notificaciones n
            LEFT JOIN admin_notificacion_estado a
                ON a.id_notificacion = n.id_notificacion
               AND a.id_admin = :id_admin
            WHERE n.activo = 1
            ORDER BY n.fecha_evento DESC, n.id_notificacion DESC
            LIMIT {$limite}
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id_admin', $idAdmin, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function contarNoLeidas(int $idAdmin): int
    {
        $this->sincronizarFuentes($idAdmin);

        $sql = "
            SELECT COUNT(*) AS total
            FROM notificaciones n
            LEFT JOIN admin_notificacion_estado a
                ON a.id_notificacion = n.id_notificacion
               AND a.id_admin = :id_admin
            WHERE n.activo = 1
              AND COALESCE(a.leida, 0) = 0
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id_admin', $idAdmin, PDO::PARAM_INT);
        $stmt->execute();

        return (int) ($stmt->fetchColumn() ?: 0);
    }

    public function marcarTodasLeidas(int $idAdmin): int
    {
        $this->sincronizarFuentes($idAdmin);

        $sql = "
            UPDATE admin_notificacion_estado a
            INNER JOIN notificaciones n ON n.id_notificacion = a.id_notificacion
            SET a.leida = 1,
                a.fecha_lectura = NOW()
            WHERE a.id_admin = :id_admin
              AND n.activo = 1
              AND a.leida = 0
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id_admin', $idAdmin, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
