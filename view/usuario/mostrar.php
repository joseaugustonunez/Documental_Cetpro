<?php
require_once("../head/head.php");
require_once("../../model/Usuario.php");


// Crear una instancia del modelo de Usuario
$usuarioModel = new Usuario();
$usuarios = $usuarioModel->listarUsuarios(); // Método que obtiene todos los usuarios

if ($usuarios): // Verificamos si hay usuarios
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
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['rol_nombre']); ?></td>
                                <td>
                                    <a class="btn btn-success" href="index.php?controller=usuario&action=editar&id=<?php echo $usuario['id']; ?>">Editar</a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario<?php echo $usuario['id']; ?>">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay usuarios registrados.</p>
            <?php endif; ?>

            <a class="btn btn-primary" href="index.php?controller=usuario&action=crear">Nuevo Usuario</a>
            <div class="modal fade" id="modalEliminarUsuario<?php echo $usuario['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <a href="index.php?controller=usuario&action=eliminar&id=<?php echo $usuario['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once("../head/footer.php");
            ?>