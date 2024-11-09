<?php
// Verifica si se ha establecido un controlador y una acción
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'usuario';
$action = isset($_GET['action']) ? $_GET['action'] : 'listar'; // Acción por defecto

// Incluye el archivo del controlador
$controllerFile = __DIR__ . '/../../controller/' . ucfirst($controller) . 'Controller.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
} else {
    echo "Error: El archivo del controlador '$controllerFile' no existe.";
    exit;
}

$controllerName = ucfirst($controller) . 'Controller';

if (class_exists($controllerName)) {
    $controllerObject = new $controllerName();

    // Verifica si la acción existe en el controlador
    if (method_exists($controllerObject, $action)) {
        // Verifica si la acción requiere un parámetro como 'id' (por ejemplo, eliminar o editar)
        if (in_array($action, ['eliminar', 'editar', 'actualizar']) && isset($_GET['id'])) {
            $id = $_GET['id'];  // Captura el parámetro 'id'
            $controllerObject->$action($id);  // Pasa el 'id' al método correspondiente
        } else {
            $controllerObject->$action();  // Llama a otras acciones sin parámetro
        }
    } else {
        echo "Error: La acción '$action' no existe en el controlador '$controllerName'.";
    }
} else {
    echo "Error: El controlador '$controllerName' no existe.";
}
