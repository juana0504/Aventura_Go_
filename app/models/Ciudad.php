<?php

require_once __DIR__ . '/../../config/database.php';
/** * Este modelo se encarga exclusivamente de interactuar con la tabla `ciudades`.
 
 * Se usa para:
 *- Cargar ciudades en formularios (select)
 * - Garantizar consistencia con llaves foráneas (id_ciudad)
 
 * NOTA:
 * No debe contener lógica de proveedores, hoteles o destinos. */
class Ciudad
{
    /** Conexión a la base de datos (PDO) */
    private $conexion;

    /**
     * Constructor
     * Inicializa la conexión a la base de datos usando la clase `conexion`
     * definida en config/database.php
     */
    public function __construct()
    {
        $db = new conexion();
        $this->conexion = $db->getConexion();
    }

    /** Obtener ciudades activas
     * Retorna todas las ciudades con estado = 1
     * ordenadas alfabéticamente.
     * Se usa para:
     * - Poblar selects simples
     * - Pruebas iniciales
     * 
     * @return array Lista de ciudades [id_ciudad, nombre]
     */


    public function obtenerCiudadesActivas()
    {
        $sql = "SELECT id_ciudad, nombre
                FROM ciudades
                WHERE estado = 1
                ORDER BY nombre";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * OBTENER CIUDADES POR DEPARTAMENTO
    
     * Este método retorna SOLO las ciudades
     * que pertenecen a un departamento específico.
    
     * Se usa cuando:
     * - El usuario selecciona un departamento
     * - El frontend hace una petición AJAX
     * - Necesitamos poblar el select de ciudades dinámicamente
     *
     * @param int $id_departamento ID del departamento seleccionado
     * @return array Lista de ciudades [id_ciudad, nombre]
     */


    public function obtenerPorDepartamento($id_departamento)
    {
        // Consulta SQL filtrando por departamento
        $sql = "SELECT id_ciudad, nombre
                FROM ciudades
                WHERE estado = 1
                AND id_departamento = :id_departamento
                ORDER BY nombre";

        // Preparamos la consulta para evitar inyección SQL
        $stmt = $this->conexion->prepare($sql);

        // Asociamos el parámetro recibido
        $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);

        // Ejecutamos la consulta
        $stmt->execute();

        // Retornamos las ciudades encontradas
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
