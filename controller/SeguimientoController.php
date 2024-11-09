<?php

class SeguimientoController
{
    private $model;

    public function __construct()
    {
        require_once("/laragon/www/sistemado/model/SeguimientoModel.php");
        $this->model = new SeguimientoModel();
    }
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start(); // Asegúrate de que la sesión esté iniciada

            // Validando entradas
            $id_tramite = $_POST['id_tramite'] ?? null;
            $comentario = $_POST['comentario'] ?? null;
            $estado_id = $_POST['estado_id'] ?? null; // Obtener el estado desde el formulario

            // Validar que los campos obligatorios no estén vacíos
            if (empty($id_tramite) || empty($comentario) || empty($estado_id)) {
                $_SESSION['error'] = "Todos los campos son obligatorios.";
                header('Location: index.php?controller=tramite&action=detalle&id=' . $id_tramite);
                exit;
            }

            // Inicializar el campo de documento
            $documento = null;

            // Manejo de carga de archivos
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
                $archivoDir = '/laragon/www/sistemado/Seguimientos/';

                // Verificar si el directorio existe, si no, crearlo
                if (!is_dir($archivoDir)) {
                    if (!mkdir($archivoDir, 0755, true)) {
                        $_SESSION['error'] = "No se pudo crear el directorio de destino para el archivo.";
                        header('Location: index.php?controller=tramite&action=detalle&id=' . $id_tramite);
                        exit;
                    }
                }

                $documentoNombre = basename($_FILES['archivo']['name']);
                $documentoRuta = $archivoDir . uniqid() . '_' . $documentoNombre;

                // Mover el archivo a la ruta de destino
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $documentoRuta)) {
                    $documento = $documentoRuta;
                } else {
                    $_SESSION['error'] = "Error al subir el archivo.";
                    header('Location: index.php?controller=tramite&action=detalle&id=' . $id_tramite);
                    exit;
                }
            }

            try {
                // Crear el seguimiento usando el modelo
                $this->model->crear($id_tramite, $comentario, $documento, $estado_id);
                $_SESSION['success'] = "Seguimiento creado correctamente.";
            } catch (Exception $e) {
                $_SESSION['error'] = "Error al crear seguimiento: " . $e->getMessage();
                error_log("Error al crear seguimiento: " . $e->getMessage());
            }

            // Redirigir a la vista de detalles del trámite
            header('Location: index.php?controller=tramite&action=detalle&id=' . $id_tramite);
            exit;
        }
    }



    public function listar($tramite_id)
    {
        return $this->model->obtenerSeguimientosPorTramite($tramite_id);
    }

    public function editar($id)
    {
        $seguimiento = $this->model->obtenerSeguimientoPorId($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nuevoComentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';
            $documento = $seguimiento['documento'];

            // Validate the new comment
            if (empty($nuevoComentario)) {
                $_SESSION['error'] = "El comentario no puede estar vacío.";
                header("Location: http://localhost/sistemado/view/tramite/index.php?controller=tramite&action=detalle&id=" . $seguimiento['tramite_id']);
                exit;
            }

            // File upload handling
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                // Validate file size and extension
                // ... (your validation logic here)

                // Move the file as before
                // ... (your moving logic here)
            }

            // Update the seguimiento in the database
            $this->model->actualizarSeguimiento($id, $nuevoComentario, $documento);
            $_SESSION['success'] = "Seguimiento actualizado correctamente.";
            header("Location: http://localhost/sistemado/view/tramite/index.php?controller=tramite&action=detalle&id=" . $seguimiento['tramite_id']);
            exit;
        }
        return $seguimiento;
    }

    public function eliminar($id)
    {
        $seguimiento = $this->model->obtenerSeguimientoPorId($id);
        if ($seguimiento) {
            $this->model->eliminarSeguimiento($id);
            $_SESSION['success'] = "Seguimiento eliminado exitosamente.";
        } else {
            $_SESSION['error'] = "No se encontró el seguimiento a eliminar.";
        }
        header("Location: http://localhost/sistemado/view/tramite/index.php?controller=tramite&action=detalle&id=" . $seguimiento['tramite_id']);
        exit;
    }
    public function mostrarSeguimientos($tramite_id)
    {
        // Asegúrate de que el modelo esté bien inicializado
        $model = new SeguimientoModel();
        // Obtener los seguimientos por trámite
        $seguimientos = $model->obtenerSeguimientosPorTramite($tramite_id);

        // Incluir la vista para mostrar los seguimientos
        include '/laragon/www/sistemado/view/seguimientos/seguimiento_view.php'; // Asegúrate de que esta ruta sea correcta
    }
}
