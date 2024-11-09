<?php
require_once '/laragon/www/sistemado/model/Usuario.php';
require_once '/laragon/www/sistemado/model/RolModel.php'; // Asegúrate de incluir tu modelo

class UsuarioController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }
    public function listar()
    {
        $usuarios = $this->usuarioModel->listarUsuarios(); // Método que obtiene todos los usuarios
        require_once '/laragon/www/sistemado/view/usuario/index.php'; // Ajusta la ruta según tu estructura
    }

    // Método para crear un nuevo usuario
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Aquí debes obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $rol_id = $_POST['rol_id'];

            // Instancia tu modelo y llama al método para crear usuario
            $usuarioModel = new Usuario();
            $result = $usuarioModel->crearUsuario($nombre, $email, password_hash($password, PASSWORD_DEFAULT), $rol_id);

            if ($result) {
                header('Location: index.php?controller=usuario&action=ver');
                exit();
            } else {
                echo "Error al crear el usuario.";
            }
        } else {
            // Mostrar el formulario de creación de usuario
            require_once('/laragon/www/sistemado/view/usuario/crear.php'); // Asegúrate de que este archivo exista
        }
    }

    // Método para ver todos los usuarios
    public function ver()
    {
        $usuarios = $this->usuarioModel->listarUsuarios(); // Asegúrate de implementar este método en tu modelo
        include '/laragon/www/sistemado/view/usuario/mostrar.php'; // Renderiza la vista de usuarios
    }
    public function editar($id)
    {
        // Llama al modelo para obtener el usuario por ID
        $usuario = $this->usuarioModel->obtenerUsuarioPorId($id);
        $rolModel = new RolModel(); // Asegúrate de que Rol sea el nombre correcto de la clase que contiene el método index()
        $roles = $rolModel->index();

        if ($usuario) {
            // Incluye la vista de edición y pasa el usuario
            require_once '/laragon/www/sistemado/view/usuario/editar.php'; // Ajusta la ruta a tu estructura de carpetas
        } else {
            echo "No se puede editar el usuario.";
        }
    }

    public function actualizar($id)
    {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
        $rol_id = $_POST['rol_id'];

        $usuarioModel = new Usuario();
        if ($usuarioModel->actualizarUsuario($id, $nombre, $email, $password, $rol_id)) {
            header('Location: index.php?controller=usuario&action=ver');
            exit();
        } else {
            echo "Error al actualizar el usuario.";
        }
    }



    // Método para eliminar un usuario
    public function eliminar($id)
    {
        if ($this->usuarioModel->eliminarUsuario($id)) { // Implementa el método eliminarUsuario en tu modelo
            header('Location: index.php?controller=usuario&action=ver');
            exit();
        } else {
            echo "Error al eliminar el usuario.";
        }
    }
}
