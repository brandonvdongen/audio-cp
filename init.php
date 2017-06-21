<?php
session_start("audio-cp");

$auth_config = parse_ini_file("auth.ini");
$auth_user = $auth_config["username"];
$auth_pass = $auth_config["password"];
$auth_database = $auth_config["database"];



$conn = new mysqli("localhost", $auth_user, $auth_pass, $auth_database);
if (!$conn) {
    #error:1
    
    echo "error, if you see this please contact the site administrator with and include the error code : 1";
    exit;


require_once __DIR__ . "controllers/auth.class.php";
