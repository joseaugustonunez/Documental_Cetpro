<?php
require_once '/laragon/www/sistemado/config/db.php';
class DerivacionModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new db())->conexion();
    }

    // Crear nueva derivación

    public function crear($comentario, $usuario_id, $tramite_id, $usuario_origen)
    {
        $sql = "INSERT INTO derivaciones (comentario, usuario_id, tramite_id, usuario_origen, created_at, updated_at) 
            VALUES (:comentario, :usuario_id, :tramite_id, :usuario_origen, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->bindParam(':usuario_id', $usuario_id);  // Usuario destino
        $stmt->bindParam(':tramite_id', $tramite_id);
        $stmt->bindParam(':usuario_origen', $usuario_origen);  // Usuario que deriva

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error al crear la derivación.");
        }
    }

    public function obtenerUsuarioPorId($usuario_id)
    {
        $sql = "
            SELECT usuarios.email, roles.nombre AS rol_nombre 
            FROM usuarios 
            INNER JOIN roles ON usuarios.rol_id = roles.id 
            WHERE usuarios.id = :usuario_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);  // Retorna el email y nombre del rol
    }

    // Listar todas las derivaciones
    public function obtenerTodas()
    {
        $sql = "SELECT * FROM derivaciones";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una derivación por ID
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM derivaciones WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una derivación
    public function actualizar($id, $comentario, $usuario_id, $tramite_id)
    {
        $sql = "UPDATE derivaciones 
                SET comentario = :comentario, usuario_id = :usuario_id, tramite_id = :tramite_id, updated_at = NOW() 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':tramite_id', $tramite_id);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function obtenerTodosPorUsuario($usuario_id)
    {
        $sql = "SELECT 
                d.*, 
                t.asunto, 
                tt.nombre AS tipo_tramite, 
                e.nombre AS estado, 
                t.nombre AS razon_social,
                u.rol_id,    -- Agregamos el rol_id del usuario que hizo la derivación
                u.nombre AS nombre_usuario_origen -- Agregamos el nombre del usuario que hizo la derivación
            FROM derivaciones d
            JOIN tramite t ON d.tramite_id = t.id
            JOIN tipo_tramite tt ON t.tipo_tramite_id = tt.id
            JOIN estado e ON t.estado_id = e.id
            JOIN usuarios u ON d.usuario_origen = u.id  -- Realizamos el JOIN con la tabla de usuarios
            WHERE d.usuario_id = :usuario_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Eliminar una derivación
    public function eliminar($id)
    {
        $sql = "DELETE FROM derivaciones WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
