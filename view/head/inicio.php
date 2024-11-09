<?php
require_once("../head/head.php");
?>
<div class="container-fluid">
    <h1>Bienvenido al Panel de <?php echo $_SESSION['rol_id']; ?>, <?php echo $_SESSION['nombre']; ?></h1>

    <?php
    require_once("../head/footer.php");
    ?>