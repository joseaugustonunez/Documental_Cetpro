<?php
class EstadoController
{
    private $model;

    public function __construct()
    {
        require_once("/laragon/www/sistemado/model/EstadoModel.php");
        $this->model = new EstadoModel();
    }

    public function listar()
    {
        $estados = $this->model->obtenerTodos();
        require_once("/laragon/www/sistemado/view/estado/mostrar.php");
    }


    public function crear()
    {
        require_once("/laragon/www/sistemado/view/estado/crear.php");
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $color = $_POST['color'];
            $id = $this->model->insertar($nombre, $descripcion, $color);
            header("Location:index.php?controller=estado&action=listar");
        }
    }

    public function editar($id)
    {
        $estado = $this->model->obtenerPorId($id);
        require_once("/laragon/www/sistemado/view/estado/editar.php");
    }

    public function actualizar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $color = $_POST['color'];
            $this->model->actualizar($id, $nombre, $descripcion, $color);
            header("Location:index.php?controller=estado&action=listar");
        }
    }

    public function eliminar($id)
    {
        $this->model->eliminar($id);
        header("Location:index.php?controller=estado&action=listar");
    }
}
