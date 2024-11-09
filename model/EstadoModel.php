<?php
class EstadoModel
{
    private $PDO;

    public function __construct()
    {
        require_once("/laragon/www/sistemado/config/db.php");
        $con = new db();
        $this->PDO = $con->conexion();
    }

    public function insertar($nombre, $descripcion, $color)
    {
        $stament = $this->PDO->prepare("INSERT INTO estado (nombre, descripcion, color) VALUES (:nombre, :descripcion, :color)");
        $stament->bindParam(":nombre", $nombre);
        $stament->bindParam(":descripcion", $descripcion);
        $stament->bindParam(":color", $color);

        return ($stament->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function obtenerTodos()
    {
        $stament = $this->PDO->prepare("SELECT * FROM estado");
        $stament->execute();
        return $stament->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stament = $this->PDO->prepare("SELECT * FROM estado WHERE id = :id");
        $stament->bindParam(":id", $id);
        $stament->execute();
        return $stament->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $descripcion, $color)
    {
        $stament = $this->PDO->prepare("UPDATE estado SET nombre = :nombre, descripcion = :descripcion, color = :color WHERE id = :id");
        $stament->bindParam(":nombre", $nombre);
        $stament->bindParam(":descripcion", $descripcion);
        $stament->bindParam(":color", $color);
        $stament->bindParam(":id", $id);
        return $stament->execute();
    }

    public function eliminar($id)
    {
        $stament = $this->PDO->prepare("DELETE FROM estado WHERE id = :id");
        $stament->bindParam(":id", $id);
        return $stament->execute();
    }
}
