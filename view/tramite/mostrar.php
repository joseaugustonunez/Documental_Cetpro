<?php
require_once("../head/head.php");
require_once("../../model/TramiteModel.php");


// Crear una instancia del modelo de Usuario
$tramiteModel = new TramiteModel();
$tramites = $tramiteModel->obtenerTodos(); // Método que obtiene todos los usuarios

if ($tramites): // Verificamos si hay usuarios
?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                </table>
                <h4>Lista de Tramites</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Asunto</th>
                            <th>Tipo Tramite</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tramites as $tramite): ?>
                            <tr>
                                <td><a href="index.php?controller=tramite&action=detalle&id=<?php echo $tramite['id']; ?>" class=" btn btn-info btn-sm m-1 rounded-circle d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                        <iconify-icon icon="mdi:eye" style="font-size: 20px;"></iconify-icon>
                                    </a>

                                    <!-- Botón con ícono circular (cancelar) -->
                                    <button type="button" class="btn btn-danger btn-sm m-1 rounded-circle d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                        <iconify-icon icon="material-symbols:cancel-outline-rounded" style="font-size: 20px;"></iconify-icon>
                                    </button>
                                </td>
                                <td><?php echo htmlspecialchars($tramite['id']); ?></td>
                                <td><?php echo htmlspecialchars($tramite['asunto']); ?></td>
                                <td><?php echo htmlspecialchars($tramite['tipo_tramite_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($tramite['estado_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($tramite['created_at']); ?></td>
                                <td>
                                    <a class="btn btn-success" href="index.php?controller=estado&action=editar&id=<?php echo $tramite['id']; ?>">Editar</a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarTramite<?php echo $tramite['id']; ?>">
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

            <a class="btn btn-primary" href="index.php?controller=estado&action=crear">Nuevo Tramite</a>
            <div class="modal fade" id="modalEliminarTramite<?php echo $tramite['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <a href="index.php?controller=tramite&action=eliminar&id=<?php echo $tramite['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <?php
        require_once("../head/footer.php");
        ?>