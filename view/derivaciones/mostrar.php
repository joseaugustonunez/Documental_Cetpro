<?php
require_once("../head/head.php");
require_once("../../model/DerivacionModel.php");

// Crear una instancia del modelo de derivaciones
$derivacionModel = new DerivacionModel($db);
$derivaciones = $derivacionModel->obtenerTodosPorUsuario($_SESSION['usuario_id']); // Método que obtiene todas las derivaciones para el usuario actual

if ($derivaciones): // Verificamos si hay derivaciones
?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <h4>Lista de Derivaciones</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Asunto</th>
                            <th>Tipo Tramite</th>
                            <th>Estado</th>
                            <th>Usuario Derivado</th>
                            <th>Razon Social</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($derivaciones as $derivacion): ?>
                            <tr>
                                <td><a href="index.php?controller=tramite&action=detalle&id=<?php echo $derivacion['tramite_id']; ?>" class=" btn btn-info btn-sm m-1 rounded-circle d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                        <iconify-icon icon="mdi:eye" style="font-size: 20px;"></iconify-icon>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($derivacion['asunto']); ?></td>
                                <td><?php echo htmlspecialchars($derivacion['tipo_tramite']); ?></td>
                                <td><?php echo htmlspecialchars($derivacion['estado']); ?></td>
                                <td><?php echo htmlspecialchars($derivacion['nombre_usuario_origen']); ?></td>
                                <td><?php echo htmlspecialchars($derivacion['razon_social']); ?></td>

                                <td>
                                    <a class="btn btn-success" href="index.php?controller=derivacion&action=editar&id=<?php echo $derivacion['id']; ?>">Editar</a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarDerivacion<?php echo $derivacion['id']; ?>">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay derivaciones registradas.</p>
            <?php endif; ?>

            <a class="btn btn-primary" href="index.php?controller=derivacion&action=crear">Nueva Derivación</a>

            <?php foreach ($derivaciones as $derivacion): ?>
                <div class="modal fade" id="modalEliminarDerivacion<?php echo $derivacion['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar la derivación?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Una vez eliminada, no se podrá recuperar la derivación.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                                <a href="index.php?controller=derivacion&action=eliminar&id=<?php echo $derivacion['id']; ?>" class="btn btn-danger">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            </div>
        </div>
    </div>

    <?php require_once("../head/footer.php"); ?>