<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: index.php');
    exit;
}
?>
<h1>Bienvenido al Panel de Usuario, <?php echo $_SESSION['nombre']; ?></h1>
<a href="logout.php">Cerrar sesión</a>