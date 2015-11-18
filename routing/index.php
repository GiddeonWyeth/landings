<?php
/**
 * Created by PhpStorm.
 * User: anton.vityazev
 * Date: 03.11.2015
 * Time: 17:36
 */

if (isset($_GET['test'])) {
    require_once 'info_getters.php';
    require_once __DIR__ . '/../models/routing_model.php';

    $ip = get_ip();
    $os = getOS($_SERVER['HTTP_USER_AGENT']);
    $browser = getBrowser($_SERVER['HTTP_USER_AGENT']);

    if (!isset($_COOKIE['guid'])) {
        $guid = com_create_guid();
        setcookie('guid', $guid, time() + (86400 * 30), "/");
    } else {
        $guid = $_COOKIE['guid'];
    }
    $referer = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';

    $db = new Routing_model();
    $info = $db->get_redirect_info(str_replace('?test', '', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
    if ($info[0]['type'] == 'Ротатор') {
        include 'rotator.php';
    } else {
        header('Location: /landings/lands/' . $info[0]['to']);
    }
}