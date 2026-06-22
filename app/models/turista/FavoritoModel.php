<?php
require_once __DIR__ . '/../../../config/database.php';

class FavoritoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new conexion())->getConexion();
    }

    /** Agrega o quita un favorito. Devuelve 'agregado' o 'eliminado'. */
    public function toggle(int $idTurista, string $tipo, int $idRef): string
    {
        $stmt = $this->db->prepare(
            "SELECT id_favorito FROM favoritos
             WHERE id_turista = ? AND tipo = ? AND id_referencia = ? LIMIT 1"
        );
        $stmt->execute([$idTurista, $tipo, $idRef]);
        $existe = $stmt->fetchColumn();

        if ($existe) {
            $this->db->prepare(
                "DELETE FROM favoritos WHERE id_turista = ? AND tipo = ? AND id_referencia = ?"
            )->execute([$idTurista, $tipo, $idRef]);
            return 'eliminado';
        }

        $this->db->prepare(
            "INSERT INTO favoritos (id_turista, tipo, id_referencia) VALUES (?, ?, ?)"
        )->execute([$idTurista, $tipo, $idRef]);
        return 'agregado';
    }

    /** Devuelve array de id_referencia favoritos del turista para un tipo. */
    public function obtenerIds(int $idTurista, string $tipo): array
    {
        $stmt = $this->db->prepare(
            "SELECT id_referencia FROM favoritos WHERE id_turista = ? AND tipo = ?"
        );
        $stmt->execute([$idTurista, $tipo]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /** Favoritos de actividades con datos completos. */
    public function listarActividades(int $idTurista): array
    {
        $sql = "
        SELECT
            f.id_favorito, f.created_at AS fecha_favorito,
            a.id_actividad, a.nombre, a.descripcion, a.precio, a.cupos,
            c.nombre AS ciudad,
            p.nombre_empresa AS proveedor,
            img.imagen
        FROM favoritos f
        INNER JOIN actividad a ON f.id_referencia = a.id_actividad
        LEFT JOIN ciudades c ON a.id_ciudad = c.id_ciudad
        LEFT JOIN proveedor p ON a.id_proveedor = p.id_proveedor
        LEFT JOIN actividad_imagen img
            ON img.id_actividad = a.id_actividad AND img.es_principal = 1
        WHERE f.id_turista = :id AND f.tipo = 'actividad'
        ORDER BY f.created_at DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idTurista]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Favoritos de hospedajes con datos completos. */
    public function listarHospedajes(int $idTurista): array
    {
        $sql = "
        SELECT
            f.id_favorito, f.created_at AS fecha_favorito,
            h.id_hospedaje, h.nombre, h.descripcion, h.precio, h.tipo AS tipo_hospedaje,
            c.nombre AS ciudad,
            ph.nombre_establecimiento AS proveedor,
            COALESCE(img.imagen, h.imagen) AS imagen
        FROM favoritos f
        INNER JOIN hospedaje h ON f.id_referencia = h.id_hospedaje
        LEFT JOIN ciudades c ON h.id_ciudad = c.id_ciudad
        LEFT JOIN proveedor_hotelero ph ON h.id_proveedor_hotelero = ph.id_proveedor_hotelero
        LEFT JOIN hospedaje_imagen img
            ON img.id_hospedaje = h.id_hospedaje AND img.es_principal = 1
        WHERE f.id_turista = :id AND f.tipo = 'hospedaje'
        ORDER BY f.created_at DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idTurista]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
