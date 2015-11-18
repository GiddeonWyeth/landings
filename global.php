<?php


$host = "localhost";
$dbname = "landings";
$user = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$dbname;user=$user;password=$password";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$pdo = new PDO($dsn, $user, $password, $opt);

$query = $pdo->prepare("SELECT landings.landings.name, landings.landings.domain_name, landings.landings.id FROM landings.landings");
$query->execute();
$global_landings = $query->fetchAll();

$query = $pdo->prepare("SELECT landings.rotator.alias FROM landings.rotator GROUP BY rotator.alias");
$query->execute();
$global_rotators = $query->fetchAll();