<?php
class TramiteModel
{
    private $PDO;

    public function __construct()
    {
        require_once("/laragon/www/sistemado/config/db.php");
        $con = new db();
        $this->PDO = $con->conexion();
    }

    public function generarCodigo()
    {
        // Obtener el último código registrado
        $stament = $this->PDO->query("SELECT codigo FROM tramite ORDER BY id DESC LIMIT 1");
        $ultimoCodigo = $stament->fetchColumn();

        // Si no hay códigos registrados, iniciar el contador
        if (!$ultimoCodigo) {
            return 'DOCSLG001';
        }

        // Extraer la parte numérica del último código
        $numero = intval(substr($ultimoCodigo, 6)) + 1; // Aumentar en uno
        return 'DOCSLG' . str_pad($numero, 3, '0', STR_PAD_LEFT); // Asegura que tenga 3 dígitos
    }

    public function insertar($asunto, $tipopersona, $codigo, $numero, $telefono, $mensaje, $documentos, $correo, $nombre, $estado_id, $tipo_tramite_id)
    {
        $sql = "INSERT INTO tramite (asunto, tipopersona, codigo, numero, telefono, mensaje, documentos, correo, nombre, estado_id, tipo_tramite_id) 
            VALUES (:asunto, :tipopersona, :codigo, :numero, :telefono, :mensaje, :documentos, :correo, :nombre, :estado_id, :tipo_tramite_id)";

        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':asunto', $asunto);
        $stmt->bindParam(':tipopersona', $tipopersona);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':mensaje', $mensaje);
        $stmt->bindParam(':documentos', $documentos);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);  // Asegúrate de que aquí se especifique que es un entero
        $stmt->bindParam(':tipo_tramite_id', $tipo_tramite_id, PDO::PARAM_INT); // Asegúrate también aquí

        return $stmt->execute();
    }
    public function obtenerTodos()
    {
        // Modificamos la consulta para incluir los nombres de tipo de trámite y estado
        $sql = "
        SELECT t.*, tt.nombre AS tipo_tramite_nombre, e.nombre AS estado_nombre
        FROM tramite t
        JOIN tipo_tramite tt ON t.tipo_tramite_id = tt.id
        JOIN estado e ON t.estado_id = e.id
    ";

        $stament = $this->PDO->query($sql);
        return $stament->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id)
    {
        $stmt = $this->PDO->prepare("
            SELECT 
                t.*, 
                tt.nombre AS tipo_tramite_nombre, 
                e.nombre AS estado_nombre, 
                e.color AS estado_color
            FROM 
                tramite t
            JOIN 
                tipo_tramite tt ON t.tipo_tramite_id = tt.id
            JOIN 
                estado e ON t.estado_id = e.id
            WHERE 
                t.id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $stament = $this->PDO->prepare("SELECT * FROM tramite");
        return ($stament->execute()) ? $stament->fetchAll() : false;
    }

    public function update($id, $estado_id)
    {
        $stament = $this->PDO->prepare("UPDATE tramite SET estado_id = :estado_id, updated_at = NOW() WHERE id = :id");
        $stament->bindParam(":estado_id", $estado_id);
        $stament->bindParam(":id", $id);
        return ($stament->execute()) ? $id : false;
    }

    public function delete($id)
    {
        $stament = $this->PDO->prepare("DELETE FROM tramite WHERE id = :id");
        $stament->bindParam(":id", $id);
        return ($stament->execute()) ? true : false;
    }
    public function buscarTramite($dni, $codigo)
    {
        // Consulta con JOIN para obtener el nombre y el color del estado
        $sql = "SELECT 
                tramite.*, 
                estado.nombre AS estado_nombre, 
                estado.color AS estado_color 
            FROM 
                tramite 
            JOIN 
                estado ON tramite.estado_id = estado.id
            WHERE 
                tramite.numero = :dni OR tramite.codigo = :codigo";

        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
