<?php
require_once("../head/head.php");

if (!isset($usuario)) {
    echo "No se puede editar el usuario.";
    exit;
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>Editar Usuario</h4>
            <form class="row g-2 needs-validation" method="POST" action="index.php?controller=usuario&action=actualizar&id=<?php echo $usuario['id']; ?>">
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Nombre</label>
                    <input class="form-control" type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Contraseña</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Rol</label>
                    <select class="form-select" name="rol_id" required>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>" <?php echo $usuario['rol_id'] == $rol['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($rol['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Actualizar Usuario</button>
                </div>
            </form>

            <?php
            require_once("../head/footer.php");
            ?>