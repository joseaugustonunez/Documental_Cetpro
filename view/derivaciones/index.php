<?php
// Asegúrate de tener la sesión iniciada si es necesario
session_start();

// Captura los parámetros enviados por la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Redirige a la página detalle del controlador tramite si se pasa el id
if ($controller == 'tramite' && $action == 'detalle' && !empty($id)) {
    // Aquí llamamos al controlador tramite y su método detalle
    header("Location: /sistemado/view/tramite/index.php?controller=tramite&action=detalle&id=$id");
    exit();
} else {
    // Si no se recibe ningún parámetro válido, puedes redirigir a una página de error o principal
    header("Location: /sistemado/index.php"); // Redirige a la página de inicio, por ejemplo
    exit();
}
