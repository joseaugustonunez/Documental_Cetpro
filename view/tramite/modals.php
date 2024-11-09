<!-- modals.php -->

<!-- Modal para Nuevo Seguimiento -->
<div class="modal fade" id="nuevoSeguimientoModal" tabindex="-1" aria-labelledby="nuevoSeguimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoSeguimientoModalLabel">Nuevo Seguimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?controller=seguimiento&action=crear" method="POST" enctype="multipart/form-data">
                    <!-- ID del trámite -->
                    <input type="hidden" name="id_tramite" value="<?php echo htmlspecialchars($tramite['id'] ?? ''); ?>">

                    <!-- Sección de selección de estado -->
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <div>
                            <?php if (!empty($estados)): ?>
                                <?php foreach ($estados as $estado): ?>
                                    <input type="radio" class="btn-check" id="estado_<?php echo htmlspecialchars($estado['id']); ?>" name="estado_id" value="<?php echo htmlspecialchars($estado['id']); ?>" autocomplete="off" required>
                                    <label class="btn btn-outline-primary estado-label"
                                        for="estado_<?php echo htmlspecialchars($estado['id']); ?>"
                                        style="
                                            border: 2px solid <?php echo htmlspecialchars($estado['color']); ?>; 
                                            color: <?php echo htmlspecialchars($estado['color']); ?>; 
                                            transition: background-color 0.3s, color 0.3s;
                                        "
                                        onclick="setActive(this, '<?php echo htmlspecialchars($estado['color']); ?>')">
                                        <?php echo htmlspecialchars($estado['nombre']); ?>
                                    </label>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay estados disponibles</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sección para el comentario -->
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentario</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea>
                    </div>

                    <!-- Sección de archivo -->
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Subir Archivo</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>

                    <!-- Botón de guardar -->
                    <button type="submit" class="btn btn-primary">Guardar Seguimiento</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Derivar -->
<div class="modal fade" id="derivarModal" tabindex="-1" aria-labelledby="derivarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="derivarModalLabel">Derivar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?controller=derivacion&action=crear" method="POST">
                    <!-- Tramite ID -->
                    <input type="hidden" name="tramite_id" value="<?php echo htmlspecialchars($tramite['id']); ?>">

                    <!-- Usuario Origen (quien deriva) -->
                    <input type="hidden" name="usuario_origen" value="<?php echo htmlspecialchars($_SESSION['usuario_id']); ?>">

                    <!-- Usuario Destino -->
                    <div class="mb-3">
                        <label for="usuario_id" class="form-label">Usuario Destino</label>
                        <select class="form-control" id="usuario_id" name="usuario_id" required>
                            <option value="">Selecciona un usuario</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?php echo $usuario['id']; ?>">
                                    <?php echo htmlspecialchars($usuario['rol_nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Motivo de Derivación -->
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo de Derivación</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Derivar</button>
                </form>
            </div>
        </div>
    </div>
</div>