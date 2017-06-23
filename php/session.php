<?php
session_name("audio-cp");
session_start();

if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = false;
    $_SESSION["nickname"] = "guest";
}
?>