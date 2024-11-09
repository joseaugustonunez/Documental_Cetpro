<?php
require_once("../head/head.php");
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>Crear Rol</h4>
            <form action="store.php" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Rol</label>
                    <input type="text" name="nombre" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>

            <?php
            require_once("../head/footer.php");
            ?>