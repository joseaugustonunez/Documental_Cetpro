<?php
session_start();

// Incluye el archivo de configuración y la clase del controlador
require_once("/laragon/www/sistemado/config/db.php");
require_once("/laragon/www/sistemado/controller/SeguimientoController.php");

// Conexión a la base de datos
// Verificar si se ha pasado un trámite ID
$tramite_id = isset($_GET['tramite_id']) ? (int)$_GET['tramite_id'] : 0;

if ($tramite_id > 0) {
    // Obtener seguimientos
    $seguimientos = $seguimientoController->listar($tramite_id);
} else {
    // Manejar el caso de error: no se proporcionó un ID de trámite
    $_SESSION['error'] = "No se proporcionó un ID de trámite.";
    header("Location: error.php"); // Redirigir a una página de error
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seguimiento de Trámites</title>
</head>

<body>
    <h1>Seguimiento de Trámites</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?php echo $_SESSION['success'];
                                    unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Comentario</th>
                <th>Documento</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($seguimientos)): ?>
                <?php foreach ($seguimientos as $seguimiento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($seguimiento['comentario']); ?></td>
                        <td><?php echo htmlspecialchars($seguimiento['documento']); ?></td>
                        <td><?php echo htmlspecialchars($seguimiento['usuario_id']); ?></td>
                        <td>
                            <a href="editar_seguimiento.php?id=<?php echo $seguimiento['id']; ?>">Editar</a>
                            <a href="eliminar_seguimiento.php?id=<?php echo $seguimiento['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay seguimientos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Agregar Seguimiento</h2>
    <form action="index.php?controller=seguimiento&action=crear" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="tramite_id" value="<?php echo $tramite_id; ?>">
        <label for="comentario">Comentario:</label>
        <textarea name="comentario" required></textarea>
        <br>
        <label for="archivo">Archivo (opcional):</label>
        <input type="file" name="archivo">
        <br>
        <input type="submit" value="Agregar Seguimiento">
    </form>
</body>

</html>