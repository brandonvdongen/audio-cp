<?php
require_once("session.php");
require_once("classes/database.class.php");
require_once("classes/auth.class.php");
require_once("classes/songfinder.class.php");
require_once("classes/song.class.php");

$database = new Database();
$auth = new Auth($database);
$perms = $auth->get_permissions();
$songfinder = new Songfinder($auth,$database);
$songs = array();
if ($songfinder instanceof Songfinder) {
    $songs = $songfinder->get_songs();
}
foreach ($songs as $i => $song) {
    if ($song instanceof Song && is_numeric($i)) {
        echo "<tr class='song-entry'>";
        echo "<td>{$song->get_name()}</td>";
        echo "<td>{$song->get_author()}</td>";
        echo "<td>{$song->get_owner()}</td>";
        echo "<td>";
        echo "<button onclick='load_id($i)'>Load</button>";
        if ($song->get_owner_id() == $auth->get_id() || $perms->edit_all) {
            echo "<button onclick='edit_id($i)'>edit</button>";
        } else {
            echo "<button disabled>edit</button>";
        }
        if ($song->get_owner_id() == $auth->get_id() || $perms->remove_all) {
            echo "<button onclick='delete_id($i)'>delete</button>";
        } else {
            echo "<button disabled>delete</button>";
        }
        echo "</td>";
        echo "</tr>";
    }
}