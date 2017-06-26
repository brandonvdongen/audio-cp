<?php
require_once("../classes/database.class.php");

$database = new Database();

$result=$database->prepared_query("SELECT * FROM songs WHERE song_name=?",[$_POST["name"]]);
if(isset($result->id_song)){
    echo "This song has been uploaded already!";
}else{
    $owner=$database->prepared_query("SELECT id_user FROM users WHERE uuid=?",[$_POST["owner"]]);
    $result=$database->prepared_query("INSERT INTO songs (id_owner, song_name, song_author, song_data) VALUES (?,?,?,?)",[$owner->id_user,$_POST["name"],$_POST["author"],$_POST["song_data"]]);
    echo "Song added!";
}
