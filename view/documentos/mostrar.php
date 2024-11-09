<?php
require_once("../head/head.php");
require_once("../../model/DocumentoModel.php");

// Cambia Usuario a Documento
$documentoModel = new Documento();
$documentos = $documentoModel->listar();
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Lista de Documentos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documentos as $documento): ?>
                        <tr>
                            <td><?php echo $documento['id']; ?></td>
                            <td><?php echo $documento['nombre']; ?></td>
                            <td>
                                <a href="index.php?controller=documento&action=editar&id=<?php echo $documento['id']; ?>" class="btn btn-success">Editar</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarDocumento<?php echo $documento['id']; ?>">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a class="btn btn-primary" href="index.php?controller=documento&action=crear">Nuevo Documento</a>
            <div class="modal fade" id="modalEliminarDocumento<?php echo $documento['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar el registro?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Una vez eliminado, no se podrá recuperar el registro.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                            <a href="index.php?controller=documento&action=eliminar&id=<?php echo $documento['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once("../head/footer.php");
            ?>