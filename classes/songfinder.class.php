<?php

class Songfinder
{
    private $auth;

    public function __construct($auth)
    {
        if (($auth instanceof auth)) {
            $this->auth = $auth;
            return true;
        } else {
            return false;
        }
    }

    public function get_songs()
    {
        $perms = $this->auth->get_permissions();
        $database = new database();

        if ($perms->see_all == 1) {
            $result = $database->prepared_query("SELECT songs.id_song, users.id_user AS id_owner, users.username AS song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_user=songs.id_owner", []);
        } else {
            $result = $database->prepared_query("SELECT songs.id_song, users.id_user AS id_owner, users.username AS song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_user=songs.id_owner WHERE public=1 OR id_owner=?", [$this->auth->get_id()]);
        }
        foreach ($result as $song) {
            $songs[$song->id_song] = new song($song->id_song, $song->id_owner, $song->song_owner, $song->song_name, $song->song_author, $song->song_data);
        }
        return $songs;
    }
}