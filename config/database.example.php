<?php
// Copiar este archivo como database.php y rellenar con las credenciales reales.
// NUNCA subir database.php al repositorio (está en .gitignore).

class conexion
{
    private $host = "localhost";       // En Hostinger: generalmente "localhost"
    private $db   = "nombre_de_tu_bd"; // Nombre de la BD creada en hPanel
    private $user = "usuario_bd";      // Usuario de la BD en hPanel
    private $pass = "contrasena_bd";   // Contraseña de la BD en hPanel
    private $conexion;

    public function __construct()
    {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8",
                $this->user,
                $this->pass
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexion: " . $e->getMessage());
        }
    }

    public function getConexion()
    {
        return $this->conexion;
    }
}
