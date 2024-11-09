<?php
require_once("../head/head.php");
?><!-- /view/documento/crear.php -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2>Nuevo Documento</h2>
            <form method="POST" action="index.php?controller=documento&action=crear">
                <div class="mb-3">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Documento</button>
            </form>
            <?php
            require_once("../head/footer.php");
            ?>