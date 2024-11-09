<?php
class RolModel
{
    private $PDO;
    public function __construct()
    {
        require_once("/laragon/www/sistemado/config/db.php");
        $con = new db();
        $this->PDO = $con->conexion();
    }
    public function insertar($nombre)
    {
        $stament = $this->PDO->prepare("INSERT INTO roles VALUES(null,:nombre)");
        $stament->bindParam(":nombre", $nombre);
        return ($stament->execute()) ? $this->PDO->lastInsertId() : false;
    }
    public function show($id)
    {
        $stament = $this->PDO->prepare("SELECT * FROM roles where id = :id limit 1");
        $stament->bindParam(":id", $id);
        return ($stament->execute()) ? $stament->fetch() : false;
    }
    public function index()
    {
        $stament = $this->PDO->prepare("SELECT * FROM roles");
        return ($stament->execute()) ? $stament->fetchAll() : false;
    }
    public function update($id, $nombre)
    {
        $stament = $this->PDO->prepare("UPDATE roles SET nombre = :nombre WHERE id = :id");
        $stament->bindParam(":nombre", $nombre);
        $stament->bindParam(":id", $id);
        return ($stament->execute()) ? $id : false;
    }
    public function delete($id)
    {
        $stament = $this->PDO->prepare("DELETE FROM roles WHERE id = :id");
        $stament->bindParam(":id", $id);
        return ($stament->execute()) ? true : false;
    }
}
