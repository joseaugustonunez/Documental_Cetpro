<?php
require_once("/laragon/www/sistemado/controller/rolcontroller.php");
$obj = new RolController();
$obj->guardar($_POST['nombre']);
