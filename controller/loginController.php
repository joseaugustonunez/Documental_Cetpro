<?php
require_once '/laragon/www/sistemado/model/Usuario.php';

class LoginController
{
    private $usuarioModel;

    public function __construct()
    {
        // Instanciar el modelo Usuario
        $this->usuarioModel = new Usuario();
        $this->crearAdmin();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $usuario = $this->usuarioModel->obtenerPorEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol_id'] = $usuario['rol_id'];

                if ($usuario['rol_id'] == 1) {
                    // Redirigir para rol 1 (por ejemplo, administrador)
                    header('Location: /sistemado/view/head/inicio.php');
                } elseif ($usuario['rol_id'] == 2) {
                    // Redirigir para rol 2 (por ejemplo, usuario normal)
                    header('Location: /sistemado/view/head/inicio.php');
                } elseif ($usuario['rol_id'] == 3) {
                    // Redirigir para rol 3 (por ejemplo, vendedor)
                    header('Location: /sistemado/view/head/inicio.php'); // Cambia a la ubicación correcta para el rol 3
                }
                exit;
            } else {
                $error = "Credenciales incorrectas.";
                require_once '/laragon/www/sistemado/view/usuario/login.php';
            }
        }
    }

    public function mostrarFormularioLogin()
    {
        require_once '/laragon/www/sistemado/view/usuario/login.php';
    }

    public function crearAdmin()
    {
        // Comprobar si ya existe un usuario con rol de administrador
        $admin = $this->usuarioModel->obtenerPorEmail('admin@admin.com');

        if (!$admin) {
            $nombre = 'Admin';
            $email = 'admin@admin.com';
            $password = password_hash('admin123', PASSWORD_DEFAULT);
            $rol_id = 1;

            if ($this->usuarioModel->crearUsuario($nombre, $email, $password, $rol_id)) {
                echo "Usuario admin creado correctamente.";
            } else {
                echo "Error al crear el usuario admin.";
            }
        } else {
            echo "El administrador ya existe.";
        }
    }
}
