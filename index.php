<?php
// index.php

// Obtiene el controlador y la acción desde la URL o establece valores por defecto
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'login';
$action = isset($_GET['action']) ? $_GET['action'] : 'mostrarFormularioLogin';

// Incluir el controlador
$controllerFile = 'controller/' . ucfirst($controller) . 'Controller.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    $controllerName = ucfirst($controller) . 'Controller';

    // Verifica si la clase existe
    if (class_exists($controllerName)) {
        $controllerObject = new $controllerName();

        // Llama a la acción correspondiente
        if (method_exists($controllerObject, $action)) {
            $controllerObject->$action();
        } else {
            echo "Error: La acción '$action' no existe en el controlador '$controllerName'.";
        }
    } else {
        echo "Error: El controlador '$controllerName' no existe.";
    }
} else {
    echo "Error: El archivo del controlador '$controllerFile' no existe.";
}
