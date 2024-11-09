<?php
require_once("/laragon/www/sistemado/controller/rolcontroller.php");
$obj = new RolController();
$obj->update($_POST['id'], $_POST['nombre']);
