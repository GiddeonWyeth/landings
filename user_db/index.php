<?php
$guid = com_create_guid();
if (!isset($_COOKIE['guid'])) {
    echo "Cookie named 'guid' is not set!";
    setcookie('guid', $guid, time() + (86400 * 30), "/");
} else {
    echo "Cookie 'guid' is set!<br>";
    echo "Value is: " . $_COOKIE['guid'];
}
