<?php
require_once("../head/head.php");

if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>Crear Estado</h4>
            <form class="row g-2 needs-validation" method="POST" action="index.php?controller=estado&action=guardar">
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Descipcion</label>
                    <input type="descripcion" name="descripcion" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label for="inputPassword5" class="form-label">Color</label>
                    <input type="color" name="color" class="form-control" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Crear Estado</button>
                </div>
            </form>
            <?php
            require_once("../head/footer.php");
            ?>