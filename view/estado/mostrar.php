<?php
require_once("../head/head.php");
require_once("../../model/EstadoModel.php");


// Crear una instancia del modelo de Usuario
$estadoModel = new EstadoModel();
$estados = $estadoModel->obtenerTodos(); // Método que obtiene todos los usuarios

if ($estados): // Verificamos si hay usuarios
?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <h4>Lista de Usuarios</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Color</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estados as $estado): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($estado['id']); ?></td>
                                <td><?php echo htmlspecialchars($estado['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($estado['descripcion']); ?></td>
                                <td style="background-color: <?php echo htmlspecialchars($estado['color']); ?>;">
                                    <?php echo htmlspecialchars($estado['color']); ?>
                                </td>
                                <td>
                                    <a class="btn btn-success" href="index.php?controller=estado&action=editar&id=<?php echo $estado['id']; ?>">Editar</a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarEstado<?php echo $estado['id']; ?>">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay Estados registrados.</p>
            <?php endif; ?>

            <a class="btn btn-primary" href="index.php?controller=estado&action=crear">Nuevo Estado</a>
            <div class="modal fade" id="modalEliminarEstado<?php echo $estado['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <a href="index.php?controller=estado&action=eliminar&id=<?php echo $estado['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once("../head/footer.php");
            ?>