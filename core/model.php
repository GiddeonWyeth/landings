<?php

class Model
{

    protected $db;

    public function __construct()
    {
        $host = "localhost";
        $dbname = "landings";
        $user = "root";
        $password = "";
        $dsn = "mysql:host=$host;dbname=$dbname;user=$user;password=$password";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        $pdo = new PDO($dsn, $user, $password, $opt);
        $this->db = $pdo;
    }

    public function __destructor()
    {
        $this->db = null;
    }

}