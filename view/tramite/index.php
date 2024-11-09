<?php
// Comprobar el controlador y la acción desde la URL
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = 'tramite'; // Controlador por defecto
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'listar'; // Acción por defecto
}

// Asegúrate de usar la ruta correcta
$controllerFile = __DIR__ . '/../../controller/' . ucfirst($controller) . 'Controller.php';
$controllerClass = ucfirst($controller) . 'Controller';

// Verifica si el archivo existe antes de requerirlo
if (file_exists($controllerFile)) {
    require_once $controllerFile; // Incluye el controlador

    $controllerObject = new $controllerClass(); // Crea una instancia del controlador

    // Verifica si el método existe en el controlador
    if (method_exists($controllerObject, $action)) {
        // Ejecuta la acción, pasando el ID si está presente
        if (isset($_GET['tramite_id'])) { // Asegúrate de usar 'tramite_id'
            $controllerObject->$action($_GET['tramite_id']);
        } elseif (isset($_GET['id'])) { // Lógica existente para 'id'
            $controllerObject->$action($_GET['id']);
        } else {
            $controllerObject->$action(); // Si no hay ID, llama la acción sin parámetros
        }
    } else {
        echo "La acción no existe.";
    }
} else {
    echo "El controlador no existe: $controllerFile";
    exit; // Salir si el controlador no se encuentra
}
