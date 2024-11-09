<?php
require_once '/laragon/www/sistemado/config/db.php';

class Documento
{
    private $db;

    public function __construct()
    {
        // Se asume que db() crea una instancia de PDO
        $this->db = (new db())->conexion();
    }

    public function listar()
    {
        $stmt = $this->db->prepare("SELECT * FROM tipo_tramite");
        $stmt->execute();
        // Usa PDO::FETCH_ASSOC
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tipo_tramite WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        // Usa PDO::FETCH_ASSOC
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO tipo_tramite (nombre) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function actualizar($id, $nombre)
    {
        $stmt = $this->db->prepare("UPDATE tipo_tramite SET nombre = :nombre WHERE id = :id");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tipo_tramite WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
