<?php
require_once("session.php");
require_once("../classes/database.class.php");
require_once("../classes/auth.class.php");
$database = new Database();
$auth = new Auth($database);
$auth->logout();
$_SESSION = [];
session_destroy();
header("Location: ../index.php");