<?php
// Archivo de entrada para manejar el controlador de Estado

// Establecer el controlador por defecto
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = 'estado'; // Cambia a 'estado' como controlador por defecto
}

// Establecer la acción por defecto
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'index'; // Cambia a 'index' como acción por defecto
}

// Ruta del archivo del controlador
$controllerFile = __DIR__ . '/../../controller/' . ucfirst($controller) . 'Controller.php';
$controllerClass = ucfirst($controller) . 'Controller';

// Verifica si el archivo del controlador existe
if (file_exists($controllerFile)) {
    require_once $controllerFile; // Incluye el controlador

    // Crear una instancia del controlador
    $controllerObject = new $controllerClass();

    // Verifica si el método existe en el controlador
    if (method_exists($controllerObject, $action)) {
        // Llama a la acción correspondiente
        if (isset($_GET['id'])) {
            $controllerObject->$action($_GET['id']);
        } else {
            $controllerObject->$action();
        }
    } else {
        echo "La acción '$action' no existe en el controlador '$controllerClass'.";
    }
} else {
    echo "El controlador '$controllerClass' no existe: $controllerFile";
    exit; // Salir si el controlador no se encuentra
}
