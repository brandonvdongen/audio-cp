<?php
require_once("../classes/session.class.php");
require_once("../classes/auth.class.php");
require_once("../classes/database.class.php");

$database = new Database();
$auth = new Auth($database);
$auth->logout();
$_SESSION = [];
session_destroy();
header("Location: ../index.php");