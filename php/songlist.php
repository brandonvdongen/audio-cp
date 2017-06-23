<?php
require_once(__DIR__ . "/session.php");
require_once(__DIR__ . "/classes.php");

$id_users = $_SESSION["id_users"];

$perm = get_permissions();

foreach ($songs as $i => $song) {
    echo "<tr class='song-entry'>\n";
    echo "<td>{$song->getname()}</td>\n";
    echo "<td>{$song->getauthor()}</td>\n";
    echo "<td>{$song->getowner()}</td>\n";
    echo "<td><button onclick='load_id($i)'>Load</button></td>\n";
    if ($song->getownerid() == $id_users || $perm->edit_all) {
        echo "<td><button onclick='edit_id($i)'>edit</button></td>\n";
    } else {
        echo "<td><button disabled>edit</button></td>\n";
    }
    if ($song->getownerid() == $id_users || $perm->remove_all) {
        echo "<td><button onclick='delete_id($i)'>delete</button></td>\n";
    } else {
        echo "<td><button disabled>delete</button></td>\n";
    }
    echo "</tr>";
}


