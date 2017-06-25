<?php
require_once("session.php");
require_once("classes.php");
$auth = new auth;
$auth->logout();
$_SESSION = [];
session_destroy();
header("Location: ../index.php");