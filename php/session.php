<?php
session_start("audio-cp");

if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = false;
    $_SESSION["perm:see_all"]=false;
    $_SESSION["perm:edit_all"]=false;
}
?>