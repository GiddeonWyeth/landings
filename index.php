<?php
var_dump($_REQUEST);
require_once 'global.php';
if (isset($_GET['param'])) {
    require_once __DIR__ . "/controllers/{$_GET['param']}_controller.php";
    require_once __DIR__ . "/views/{$_GET['param']}_view.php";
} else {
    $_GET['param'] = 'interface';
    require_once __DIR__ . '/controllers/interface_controller.php';
    require_once __DIR__ . '/views/view.php';
}



