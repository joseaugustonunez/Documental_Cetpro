<?php
require_once("../head/head.php");
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Editar Documento</h2>
            <form method="POST" action="index.php?controller=documento&action=editar&id=<?php echo $documento['id']; ?>">
                <div class="mb-3">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($documento['nombre']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Documento</button>
            </form>
            <?php
            require_once("../head/footer.php");
            ?>