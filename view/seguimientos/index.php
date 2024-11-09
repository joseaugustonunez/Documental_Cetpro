<?php
require_once("/laragon/www/sistemado/config/db.php");
require_once("/laragon/www/sistemado/controller/SeguimientoController.php");

$tramite_id = $_GET['tramite_id']; // Asegúrate de validar y sanitizar la entrada
$controller->mostrarSeguimientos($tramite_id);
