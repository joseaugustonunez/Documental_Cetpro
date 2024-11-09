<?php
require_once '/laragon/www/sistemado/config/db.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        // Inicializar la conexión a la base de datos
        $this->db = (new db())->conexion();
    }

    // Método para obtener un usuario por su email
    public function obtenerPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un usuario
    public function crearUsuario($nombre, $email, $password, $rol_id)
    {
        $sql = "INSERT INTO usuarios (nombre, email, password, rol_id) VALUES (:nombre, :email, :password, :rol_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':rol_id', $rol_id);
        return $stmt->execute();
    }
    public function listarUsuarios()
    {
        $sql = "SELECT u.id, u.nombre, u.email, u.password, u.rol_id, r.nombre AS rol_nombre 
                FROM usuarios u 
                JOIN roles r ON u.rol_id = r.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function usuarioRol()
    {
        // Consulta SQL para obtener los roles de los usuarios
        $sql = "SELECT usuarios.id, roles.nombre AS rol_nombre 
                FROM usuarios
                JOIN roles ON usuarios.rol_id = roles.id";

        // Preparar la consulta
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        // Retornar los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Método para obtener un usuario por ID
    public function obtenerUsuarioPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarUsuario($id, $nombre, $email, $password, $rol_id)
    {
        // Construimos el SQL dinámicamente según si hay o no contraseña nueva
        if ($password) {
            $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, password = :password, rol_id = :rol_id WHERE id = :id";
        } else {
            $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, rol_id = :rol_id WHERE id = :id";
        }

        // Preparamos la consulta
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol_id', $rol_id);
        $stmt->bindParam(':id', $id);

        // Solo bindear password si no es nulo
        if ($password) {
            $stmt->bindParam(':password', $password);
        }

        // Ejecutar y devolver el resultado
        return $stmt->execute();
    }


    // Método para eliminar un usuario
    public function eliminarUsuario($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
