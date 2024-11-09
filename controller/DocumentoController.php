<?php
require_once '/laragon/www/sistemado/model/DocumentoModel.php';

class DocumentoController
{
    private $documentoModel;

    public function __construct()
    {
        $this->documentoModel = new Documento();
    }

    public function listar()
    {
        $documentos = $this->documentoModel->listar();
        require_once '/laragon/www/sistemado/view/documentos/mostrar.php';
    }

    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            if ($this->documentoModel->crear($nombre)) {
                header('Location: index.php?controller=documento&action=listar');
            } else {
                echo "Error al crear el documento.";
            }
        } else {
            require_once '/laragon/www/sistemado/view/documentos/crear.php';
        }
    }

    public function editar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            if ($this->documentoModel->actualizar($id, $nombre)) {
                header('Location: index.php?controller=documento&action=listar');
            } else {
                echo "Error al actualizar el documento.";
            }
        } else {
            $documento = $this->documentoModel->obtenerPorId($id);
            require_once '/laragon/www/sistemado/view/documentos/editar.php';
        }
    }

    public function eliminar($id)
    {
        if ($this->documentoModel->eliminar($id)) {
            header('Location: index.php?controller=documento&action=listar');
        } else {
            echo "Error al eliminar el documento.";
        }
    }
}
