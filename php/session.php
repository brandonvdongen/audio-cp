<?php
session_start("audio-cp");

if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = false;
    $_SESSION["nickname"] = "guest";
}
?>