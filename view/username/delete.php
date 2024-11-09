<?php
require_once("/laragon/www/sistemado/controller/rolcontroller.php");
$obj = new RolController();
$obj->delete($_GET['id']);
