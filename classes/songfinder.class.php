<?php

class Songfinder
{
    private $auth;
    private $database;
    public function __construct($auth,$database)
    {
        if (($auth instanceof auth)&&($database instanceof Database)) {
            $this->auth = $auth;
            $this->database = $database;
            return true;
        } else {
            return false;
        }
    }

    public function get_songs()
    {
        if (!($database instanceof Database)) {
            return false;
        }
        $perms = $this->auth->get_permissions();

        if ($perms->see_all == 1) {
            $result = $database->prepared_query("SELECT songs.id_song, users.id_user AS id_owner, users.username AS song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_user=songs.id_owner", []);
        } else {
            $result = $database->prepared_query("SELECT songs.id_song, users.id_user AS id_owner, users.username AS song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_user=songs.id_owner WHERE public=1 OR id_owner=?", [$this->auth->get_id()]);
        }
        $songs = array();
        foreach ($result as $song) {
            $songs[$song->id_song] = new song($song->id_song, $song->id_owner, $song->song_owner, $song->song_name, $song->song_author, $song->song_data);
        }
        return $songs;
    }
    public function get_song_perm(){}
}