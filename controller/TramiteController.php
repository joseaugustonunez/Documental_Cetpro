<?php

require 'C:\laragon\www\sistemado\PHPMailer\src\Exception.php';
require 'C:\laragon\www\sistemado/PHPMailer/src/PHPMailer.php';
require 'C:\laragon\www\sistemado/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class TramiteController
{
    private $model;
    private $pdo;

    public function __construct()
    {

        require_once("/laragon/www/sistemado/model/TramiteModel.php");
        $this->model = new TramiteModel();
        $db = new db(); // Crear una instancia de la clase db
        $this->pdo = $db->conexion(); // Obtener la conexión PDO
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir datos del formulario
            $asunto = $_POST['asunto'] ?? null;
            $tipopersona = $_POST['tipopersona'] ?? null;
            $numero = $_POST['numero'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $mensaje = $_POST['mensaje'] ?? null;
            $documentos = $_FILES['documentos'] ?? null; // Maneja documentos adecuadamente
            $correo = $_POST['correo'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $tipo_tramite_id = $_POST['tipo_tramite_id'] ?? null;

            // Estado ID por defecto
            $estado_id = 1; // Asegúrate que este es un entero

            // Arreglo para almacenar los campos requeridos
            $requiredFields = [
                'asunto' => $asunto,
                'tipopersona' => $tipopersona,
                'numero' => $numero,
                'telefono' => $telefono,
                'mensaje' => $mensaje,
                'documentos' => $documentos['name'] ?? null, // Solo el nombre del archivo
                'correo' => $correo,
                'nombre' => $nombre,
                'tipo_tramite_id' => $tipo_tramite_id,
            ];

            // Verificar que todos los campos requeridos estén presentes
            foreach ($requiredFields as $field => $value) {
                if (empty($value)) {
                    header("Location: create.php?error=faltan_datos&campo={$field}");
                    exit; // Asegúrate de salir después de redirigir
                }
            }

            // Verificar si el archivo se ha subido correctamente
            if ($documentos && $documentos['error'] === UPLOAD_ERR_OK) {
                // Definir la carpeta de destino
                $carpetaDestino = '/laragon/www/sistemado/Documentos/'; // Asegúrate de que termine en /

                // Asegúrate de que la carpeta exista, si no, créala
                if (!is_dir($carpetaDestino)) {
                    if (!mkdir($carpetaDestino, 0755, true)) {
                        header("Location: create.php?error=error_crear_carpeta");
                        exit;
                    }
                }

                // Crear un nombre único para el archivo
                $nombreDocumento = uniqid() . '-' . basename($documentos['name']); // Generar un nombre único
                $rutaCompleta = $carpetaDestino . $nombreDocumento; // Ruta completa del archivo

                // Mover el archivo a la carpeta de destino
                if (!move_uploaded_file($documentos['tmp_name'], $rutaCompleta)) {
                    header("Location: create.php?error=error_mover_archivo");
                    exit;
                }
            } else {
                header("Location: create.php?error=archivo_no_subido");
                exit;
            }

            // Generar el código automáticamente usando el modelo
            $codigo = $this->model->generarCodigo();

            // Insertar datos en la base de datos con la ruta completa del archivo
            $id = $this->model->insertar($asunto, $tipopersona, $codigo, $numero, $telefono, $mensaje, $rutaCompleta, $correo, $nombre, (int)$estado_id, (int)$tipo_tramite_id);

            if ($id !== false) {
                // Enviar correo de confirmación
                $mail = new PHPMailer(true);
                try {
                    // Configuración del servidor
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'joseaugustonunezvicente@gmail.com'; // Cambia esto por tu correo
                    $mail->Password   = 'iqly hjia rkrd ndto';       // Cambia esto por tu contraseña
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->CharSet = 'UTF-8';

                    // Destinatarios
                    $mail->setFrom('joseaugustonunezvicente@gmail.com', 'Sistema de Trámites');
                    $mail->addAddress($correo); // Usa el correo ingresado por el usuario

                    // Lee el contenido del archivo HTML
                    $emailTemplate = file_get_contents('C:\laragon\www\sistemado\email\email_template.html');

                    // Reemplaza el marcador de posición con el valor de $codigo
                    $emailTemplate = str_replace('{{codigo}}', $codigo, $emailTemplate);

                    // Configuración del correo
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirmación de Trámite';
                    $mail->Body = $emailTemplate;
                    $mail->AltBody = "Su trámite ha sido realizado con éxito. Código de su documento: $codigo"; // Texto plano

                    // Envía el correo
                    $mail->send();

                    // Opcional: Mostrar un mensaje de éxito en la página
                } catch (Exception $e) {
                    // Manejo de errores si el correo no se envió
                    header("Location: create.php?error=correo_no_enviado");
                    exit;
                }

                // Redirigir con mensaje de éxito
                header("Location: index.php?controller=tramite&action=mostrar");
                exit; // Asegúrate de salir después de redirigir
            } else {
                header("Location: create.php?error=insercion");
                exit;
            }
        } else {
            header("Location: create.php?error=metodo_no_permitido");
            exit;
        }
    }

    public function detalle($id)
    {
        // Validar que el ID esté presente y sea un número
        if (!isset($id) || !is_numeric($id)) {
            header('Location: index.php?controller=tramite&action=listar');
            exit;
        }

        // Obtener detalles del trámite por ID usando el modelo
        $tramite = $this->model->obtenerPorId($id);

        // Verificar si se obtuvo el trámite
        if (!$tramite) {
            header('Location: index.php?controller=tramite&action=listar&error=no_encontrado');
            exit;
        }

        // Cargar la vista para mostrar los detalles
        require_once '/laragon/www/sistemado/view/tramite/show.php';
    }
    public function mostrar()
    {
        include '/laragon/www/sistemado/view/tramite/mostrar.php'; // La vista para mostrar todos los trámites
    }

    public function index()
    {
        return $this->model->index() ?: false;
    }

    public function update($id, $estado_id)
    {
        if ($this->model->update($id, $estado_id) !== false) {
            header("Location:index.php?controller=tramite&action=show&id=" . $id);
        } else {
            header("Location:index.php?controller=tramite&action=index");
        }
    }

    public function eliminar($id)
    {
        $this->model->delete($id);
        header("Location:index.php?controller=tramite&action=mostrar");
    }
    public function buscar()
    {
        $resultados = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dni = $_POST['dni'];
            $codigo = $_POST['codigo'];

            // Realizar la búsqueda en el modelo
            $resultados = $this->model->buscarTramite($dni, $codigo);
        }

        // Incluir la vista y pasar los resultados
        require_once '/laragon/www/sistemado/view/tramite/consulta.php';  // la vista actual modificada
    }
}
