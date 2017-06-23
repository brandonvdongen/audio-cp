<?php
require_once(__DIR__ . "/session.php");
require_once(__DIR__ . "/classes.php");

$auth = new auth();
$perms=$auth->get_permissions();
$songfinder = new songfinder($auth);
$songs = $songfinder->get_songs();
foreach ($songs as $i => $song) {
    echo "<tr class='song-entry'>\n";
    echo "<td>{$song->get_name()}</td>\n";
    echo "<td>{$song->get_author()}</td>\n";
    echo "<td>{$song->get_owner()}</td>\n";
    echo "<td><button onclick='load_id($i)'>Load</button></td>\n";
    if ($song->get_owner_id() == $auth->get_id() || $perm->edit_all) {
        echo "<td><button onclick='edit_id($i)'>edit</button></td>\n";
    } else {
        echo "<td><button disabled>edit</button></td>\n";
    }
    if ($song->get_owner_id() == $auth->get_id() || $perm->remove_all) {
        echo "<td><button onclick='delete_id($i)'>delete</button></td>\n";
    } else {
        echo "<td><button disabled>delete</button></td>\n";
    }
    echo "</tr>";
}


