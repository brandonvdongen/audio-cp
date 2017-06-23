<?php

/**
 * Created by PhpStorm.
 * User: brand
 * Date: 23-6-2017
 * Time: 19:42
 */
class songfinder
{
    private $conn;
    private $auth_config;
    private $auth_user;
    private $auth_pass;
    private $auth_database;

    public function __construct(){
        $this->auth_config = parse_ini_file("auth.ini");
        $this->auth_user = $auth_config["username"];
        $this->auth_pass = $auth_config["password"];
        $this->auth_database = $auth_config["database"];
        $this->conn = new PDO("mysql:host=localhost;dbname=$this->auth_database", $this->auth_user, $this->auth_pass);
    }
}