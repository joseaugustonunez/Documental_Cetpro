<?php
class SeguimientoModel
{
    private $db;

    public function __construct()
    {
        require_once("/laragon/www/sistemado/config/db.php");
        $con = new db();
        $this->db = $con->conexion(); // Cambié $this->PDO a $this->db
    }

    public function crear($id_tramite, $comentario, $documento, $estado_id)
    {
        try {
            // Iniciar una transacción para asegurar que ambos procesos se completen
            $this->db->beginTransaction();

            // Insertar el seguimiento
            $querySeguimiento = "INSERT INTO seguimiento (comentario, documento, usuario_id, tramite_id, estado_id, created_at) 
                                 VALUES (:comentario, :documento, :usuario_id, :tramite_id, :estado_id, NOW())";
            $stmtSeguimiento = $this->db->prepare($querySeguimiento);
            $stmtSeguimiento->bindParam(':comentario', $comentario);
            $stmtSeguimiento->bindParam(':documento', $documento);
            $stmtSeguimiento->bindParam(':usuario_id', $_SESSION['usuario_id']); // Asegúrate de que el ID del usuario está en la sesión
            $stmtSeguimiento->bindParam(':tramite_id', $id_tramite);
            $stmtSeguimiento->bindParam(':estado_id', $estado_id);

            if (!$stmtSeguimiento->execute()) {
                throw new Exception("Error al insertar seguimiento: " . implode(", ", $stmtSeguimiento->errorInfo()));
            }

            // Actualizar el estado en la tabla tramite
            $queryTramite = "UPDATE tramite SET estado_id = :estado_id WHERE id = :tramite_id";
            $stmtTramite = $this->db->prepare($queryTramite);
            $stmtTramite->bindParam(':estado_id', $estado_id); // Actualizar el estado en la tabla tramite
            $stmtTramite->bindParam(':tramite_id', $id_tramite);

            if (!$stmtTramite->execute()) {
                throw new Exception("Error al actualizar el estado del trámite: " . implode(", ", $stmtTramite->errorInfo()));
            }

            // Confirmar la transacción
            $this->db->commit();
        } catch (Exception $e) {
            // Si hay algún error, revertir la transacción
            $this->db->rollBack();
            throw new Exception("Transacción fallida: " . $e->getMessage());
        }
    }
    public function obtenerSeguimientosPorTramite($tramite_id)
    {
        $query = "
        SELECT 
            s.*, 
            r.nombre AS rol_nombre,
            e.nombre AS estado_nombre,
            e.color AS estado_color
        FROM 
            seguimiento s
        JOIN 
            usuarios u ON s.usuario_id = u.id
        JOIN 
            roles r ON u.rol_id = r.id  
        JOIN 
            estado e ON s.estado_id = e.id
        WHERE 
            s.tramite_id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$tramite_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Método para obtener los estados
    public function obtenerEstados()
    {
        $sql = "SELECT id, nombre FROM estados";
        $query = $this->db->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerSeguimientoPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM seguimiento WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarSeguimiento($id, $comentario, $documento)
    {
        $stmt = $this->db->prepare("UPDATE seguimiento SET comentario = ?, documento = ? WHERE id = ?");
        return $stmt->execute([$comentario, $documento, $id]);
    }

    public function eliminarSeguimiento($id)
    {
        $stmt = $this->db->prepare("DELETE FROM seguimiento WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
