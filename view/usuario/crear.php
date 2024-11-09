<?php
require_once("../head/head.php");
require_once("../../model/RolModel.php"); // Asegúrate de incluir el modelo de Rol

// Crear una instancia del modelo de Rol
$rolModel = new RolModel();
$roles = $rolModel->index(); // Obtener la lista de roles

if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>Crear Usuario</h4>
            <form class="row g-2 needs-validation" method="POST" action="index.php?controller=usuario&action=crear">
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Rol</label>
                    <select class="form-select" name="rol_id" required>
                        <option value="">Selecciona un Rol</option> <!-- Opción por defecto -->
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>"><?php echo htmlspecialchars($rol['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Crear Usuario</button>
                </div>
            </form>
            <?php
            require_once("../head/footer.php");
            ?>