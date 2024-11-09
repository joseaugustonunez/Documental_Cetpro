<?php
require_once("../head/head.php");
require_once("../../model/TramiteModel.php");
require_once("../../model/EstadoModel.php");
require_once("../../model/SeguimientoModel.php");
require_once("../../model/Usuario.php");
$usuario_id = $_SESSION['usuario_id'];
$estadoModel = new EstadoModel();
$estados = $estadoModel->obtenerTodos();
$usuarioModel = new Usuario();
$usuarios = $usuarioModel->usuarioRol();
$seguimientoModel = new SeguimientoModel();
$seguimientos = $seguimientoModel->obtenerSeguimientosPorTramite($tramite['id']);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <div class="container mt-5">
                <h2>Detalles del Trámite</h2>

                <!-- Botones de acción -->
                <div class="mb-3">
                    <a href="cancelar.php?id=<?php echo $tramite['id']; ?>" class="btn btn-danger btn-sm m-1" title="Cancelar">
                        <iconify-icon icon="mdi:cancel"></iconify-icon> Cancelar
                    </a>
                    <button type="button" class="btn btn-primary btn-sm m-1" data-bs-toggle="modal" data-bs-target="#nuevoSeguimientoModal" data-id="<?php echo $tramite['id']; ?>">
                        <iconify-icon icon="mdi:plus-circle"></iconify-icon> Nuevo Seguimiento
                    </button>

                    <!-- Botón para abrir la modal de Derivar -->
                    <button type="button" class="btn btn-info btn-sm m-1" data-bs-toggle="modal" data-bs-target="#derivarModal" data-id="<?php echo $tramite['id']; ?>">
                        <iconify-icon icon="mdi:arrow-right"></iconify-icon> Derivar
                    </button>
                </div>
                <table class="table table-hover table-striped table-bordered mt-4">
                    <tbody>
                        <tr>
                            <th>Asunto</th>
                            <td><?php echo htmlspecialchars($tramite['asunto']); ?></td>
                        </tr>
                        <tr>
                            <th>Tipo de Persona</th>
                            <td><?php echo htmlspecialchars($tramite['tipopersona']); ?></td>
                        </tr>
                        <tr>
                            <th>Código del Trámite</th>
                            <td><?php echo htmlspecialchars($tramite['codigo']); ?></td>
                        </tr>
                        <tr>
                            <th>Número de Documento</th>
                            <td><?php echo htmlspecialchars($tramite['numero']); ?></td>
                        </tr>
                        <tr>
                            <th>Teléfono</th>
                            <td><?php echo htmlspecialchars($tramite['telefono']); ?></td>
                        </tr>
                        <tr>
                            <th>Mensaje</th>
                            <td><?php echo nl2br(htmlspecialchars($tramite['mensaje'])); ?></td>
                        </tr>
                        <tr>
                            <th>Correo</th>
                            <td><?php echo htmlspecialchars($tramite['correo']); ?></td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td><?php echo htmlspecialchars($tramite['nombre']); ?></td>
                        </tr>
                        <tr>
                            <th>Tipo de Trámite</th>
                            <td>
                                <span class="badge rounded-pill text-bg-warning">
                                    <?php echo htmlspecialchars($tramite['tipo_tramite_nombre']); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>
                                <span class="badge rounded-pill" style="background-color: <?php echo htmlspecialchars($tramite['estado_color']); ?>; color: #ffffff;">
                                    <?php echo htmlspecialchars($tramite['estado_nombre']); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Documentos</th>
                            <td>
                                <a href="http://localhost/sistemado/Documentos/<?php echo str_replace(' ', '%20', basename($tramite['documentos'])); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                    Ver Documento
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="index.php?controller=tramite&action=mostrar" class="btn btn-secondary">Volver a la lista</a>
            </div>
            <?php include 'modals.php'; ?>
            <h3>Seguimientos</h3>

            <table class="table table-hover table-striped table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Comentario</th>
                        <th>Documento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($seguimientos) > 0): ?>
                        <?php foreach ($seguimientos as $seguimiento): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($seguimiento['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($seguimiento['rol_nombre']); // Aquí deberías reemplazar con el nombre del usuario 
                                    ?></td>
                                <td><?php echo htmlspecialchars($seguimiento['comentario']); ?></td>
                                <td>
                                    <?php if (!empty($seguimiento['documento'])): ?>
                                        <a href="http://localhost/sistemado/Seguimientos/<?php echo str_replace(' ', '%20', basename($seguimiento['documento'])); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                            Ver Documento
                                        </a>
                                    <?php else: ?>
                                        Sin documento
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="background-color: <?php echo htmlspecialchars($seguimiento['estado_color']); ?>; color: #ffffff;">
                                        <?php echo htmlspecialchars($seguimiento['estado_nombre']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No hay seguimientos para este trámite.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <script>
                function setActive(label, color) {
                    // Reset all labels
                    const labels = document.querySelectorAll('.estado-label');
                    labels.forEach(lbl => {
                        lbl.style.backgroundColor = ''; // Eliminar color de fondo
                        lbl.style.color = lbl.style.borderColor; // Restablecer el color de texto al color del borde
                    });

                    // Set the active label's styles
                    label.style.backgroundColor = color; // Cambiar el color de fondo
                    label.style.color = 'white'; // Cambiar el color de texto a blanco
                }

                const nuevoSeguimientoModal = document.getElementById('nuevoSeguimientoModal');
                nuevoSeguimientoModal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget; // Botón que abre el modal
                    const idTramite = button.getAttribute('data-id'); // Extraer el ID del trámite
                    const idInput = document.getElementById('id_tramite_seguimiento'); // Input oculto en el modal
                    idInput.value = idTramite; // Asignar el ID al input oculto
                });

                const derivarModal = document.getElementById('derivarModal');
                derivarModal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget; // Botón que abre el modal
                    const idTramite = button.getAttribute('data-id'); // Extraer el ID del trámite
                    const idInput = document.getElementById('id_tramite_derivacion'); // Input oculto en el modal
                    idInput.value = idTramite; // Asignar el ID al input oculto
                });
            </script>
            <?php
            require_once("../head/footer.php");
            ?>