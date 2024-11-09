<?php
require_once '/laragon/www/sistemado/model/DerivacionModel.php';
require 'C:\laragon\www\sistemado/PHPMailer/src/Exception.php';
require 'C:\laragon\www\sistemado/PHPMailer/src/PHPMailer.php';
require 'C:\laragon\www\sistemado/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DerivacionController
{
    private $model;

    public function __construct()
    {
        $this->model = new DerivacionModel();
    }

    // Método para mostrar todas las derivaciones
    public function index()
    {
        $derivaciones = $this->model->obtenerTodas();
        include 'views/derivacion/index.php';
    }

    // Mostrar el formulario de creación
    public function create()
    {
        include 'views/derivacion/create.php';
    }

    // Guardar una nueva derivación
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start(); // Asegúrate de que la sesión está iniciada

            // Validando entradas
            $comentario = $_POST['comentario'] ?? null;
            $usuario_id = $_POST['usuario_id'] ?? null;
            $tramite_id = $_POST['tramite_id'] ?? null;
            $usuario_origen = $_POST['usuario_origen'] ?? null;

            // Validar que los campos obligatorios no estén vacíos
            if (empty($comentario) || empty($usuario_id) || empty($tramite_id) || empty($usuario_origen)) {
                $_SESSION['error'] = "Todos los campos son obligatorios.";
                header('Location: index.php?controller=tramite&action=detalle&id=' . $tramite_id);
                exit;
            }

            try {
                // Crear la derivación
                $this->model->crear($comentario, $usuario_id, $tramite_id, $usuario_origen);

                // Obtener el correo y rol del usuario destino
                $usuarioDestino = $this->model->obtenerUsuarioPorId($usuario_id);
                $usuarioOrigen = $this->model->obtenerUsuarioPorId($usuario_origen);
                if ($usuarioDestino) {
                    // Enviar correo
                    $mail = new PHPMailer(true);

                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Cambia esto al host correcto
                    $mail->SMTPAuth = true;
                    $mail->Username = 'joseaugustonunezvicente@gmail.com'; // Tu correo
                    $mail->Password = 'iqly hjia rkrd ndto'; // Asegúrate de que esto sea seguro
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587; // Puerto para TLS

                    $mail->CharSet = 'UTF-8';

                    // Configuración del correo
                    $mail->setFrom('joseaugustonunezvicente@gmail.com', 'Sistema de Trámites');
                    $mail->addAddress($usuarioDestino['email']); // Correo del usuario destino

                    $htmlTemplate = file_get_contents('C:\laragon\www\sistemado\email\email_derivar.html');

                    // Reemplazar las variables en el contenido HTML
                    $htmlTemplate = str_replace('{{usuarioDestino}}', $usuarioDestino['rol_nombre'], $htmlTemplate);
                    $htmlTemplate = str_replace('{{usuarioOrigen}}', $usuarioOrigen['rol_nombre'], $htmlTemplate);
                    $htmlTemplate = str_replace('{{comentario}}', $comentario, $htmlTemplate);

                    // Configurar PHPMailer
                    $mail->isHTML(true);
                    $mail->Subject = 'Notificación de asignación de trámite';
                    $mail->Body = $htmlTemplate;

                    // Habilitar depuración
                    //$mail->SMTPDebug = 2; // Cambia a 2 para depuración

                    // Enviar el correo
                    $mail->send();
                }

                $_SESSION['success'] = "Derivación creada y correo enviado correctamente.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Error al crear derivación o enviar el correo: " . $e->getMessage();
                error_log("Error al crear derivación o enviar correo: " . $e->getMessage());
            }

            // Redirigir a la vista de detalles del trámite
            header('Location: index.php?controller=tramite&action=detalle&id=' . $tramite_id);
            exit;
        }
    }


    // Mostrar el formulario de edición
    public function edit($id)
    {
        $derivacion = $this->model->obtenerPorId($id);
        include 'views/derivacion/edit.php';
    }

    // Actualizar una derivación existente
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comentario = $_POST['comentario'];
            $usuario_id = $_POST['usuario_id'];
            $tramite_id = $_POST['tramite_id'];

            if ($this->model->actualizar($id, $comentario, $usuario_id, $tramite_id)) {
                header('Location: index.php?controller=derivacion&action=index');
                exit();
            } else {
                echo "Error al actualizar la derivación.";
            }
        }
    }
    public function listarDerivaciones()
    {
        return $this->model->obtenerTodas();
    }


    // Listar derivaciones para el usuario autenticado

    public function listar()
    {
        session_start();
        if (isset($_SESSION['usuario_id'])) {
            $usuario_id = $_SESSION['usuario_id'];
            $derivaciones = $this->model->obtenerTodosPorUsuario($usuario_id);
            require_once("../view/derivaciones/mostrar.php");
        } else {
            echo "No hay sesión iniciada.";
        }
    }
    public function delete($id)
    {
        if ($this->model->eliminar($id)) {
            header('Location: index.php?controller=derivacion&action=index');
            exit();
        } else {
            echo "Error al eliminar la derivación.";
        }
    }
}
