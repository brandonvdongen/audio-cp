<?php
require_once(__DIR__ . "/session.php");
require_once(__DIR__ . "/auth.php");
require_once(__DIR__ . "/songs.class.php");

$id_users = $_SESSION["id_users"];

$perm = get_permissions();
if ($perm->see_all == 1) {
    $stmt = $conn->prepare("SELECT songs.id_songs, users.id_users as id_owner, users.username as song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_users=songs.id_owner");
} else {
    $stmt = $conn->prepare("SELECT songs.id_songs, users.id_users as id_owner, users.username as song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_users=songs.id_owner WHERE public=1 OR id_owner=?");
}
$stmt->bindValue(1, $id_users);
$stmt->execute();
$songs = array();
while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
    $songs[] = new song($result->id_songs, $result->id_owner, $result->song_owner, $result->song_name, $result->song_author, $result->song_data);
}
foreach ($songs as $i => $song) {
    echo "<tr class='song-entry'>";
    echo "<td>{$song->getname()}</td>";
    echo "<td>{$song->getauthor()}</td>";
    echo "<td>{$song->getowner()}</td>";
    if ($song->getownerid() == $id_users || $perm->edit_all) {
        echo "<td><button onclick='edit_id({$song->getid()})'>edit</button></td>";
    } else {
        echo "<td><button disabled>edit</button></td>";
    }
    if ($song->getownerid() == $id_users || $perm->remove_all) {
        echo "<td><button onclick='delete_id({$song->getid()})'>delete</button></td>";
    } else {
        echo "<td><button disabled>delete</button></td>";
    }
    echo "</tr>";
}


