<?php
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = 'documento';
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'listar';
}

// Asegúrate de usar la ruta correcta
$controllerFile = __DIR__ . '/../../controller/' . ucfirst($controller) . 'Controller.php';
$controllerClass = ucfirst($controller) . 'Controller';

// Verifica si el archivo existe antes de requerirlo
if (file_exists($controllerFile)) {
    require_once $controllerFile; // Asegúrate de incluir el controlador

    $controllerObject = new $controllerClass();

    if (method_exists($controllerObject, $action)) {
        if (isset($_GET['id'])) {
            $controllerObject->$action($_GET['id']);
        } else {
            $controllerObject->$action();
        }
    } else {
        echo "La acción no existe.";
    }
} else {
    echo "El controlador no existe: $controllerFile";
    exit; // Salir si el controlador no se encuentra
}
