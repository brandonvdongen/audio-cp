<?php

class database
{
    private $conn;
    private $user;
    private $pass;
    private $database;
    private $result;

    public function __construct()
    {
        $auth_config = parse_ini_file("auth.ini");
        $this->user = $auth_config["username"];
        $this->pass = $auth_config["password"];
        $this->database = $auth_config["database"];
        $this->conn = new PDO("mysql:host=localhost;dbname=$this->database", $this->user, $this->pass);
    }

    public function prepared_query($query, $bindings)
    {
        $stmt = $this->conn->prepare($query);
        foreach ($bindings as $i => $bind) {
            $stmt->bindValue($i, $bind);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

class auth
{
    const SESSION_VAR = "id_user";
    private $database;

    public function __construct()
    {

        $this->database = new database();
        if (isset($_SESSION[self::SESSION_VAR])) {
            $this->verify_login($_SESSION[self::SESSION_VAR]);
        }
    }

    public function verify_login($id)
    {
        if (!is_numeric($id)) {
            return false;
        } else {

            $this->database->prepared_query("SELECT * FROM users where users.username");
        }
    }

    public function set_id($id_user)
    {
        $this->id_user = $id_user;
    }

    public
    function get_permissions()
    {
        $conn = new database();
        $stmt = $conn->prepare("SELECT * FROM permissions INNER JOIN users ON users.id_user=permissions.id_permissions WHERE users.id_user=?");
        $stmt->bindValue(1, $this->id_user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}

class song
{
    private $id;
    private $owner;
    private $idowner;
    private $name;
    private $author;
    private $data;

    public function __construct($id, $idowner, $owner, $name, $author, $data)
    {
        $this->id = $id;
        $this->idowner = $idowner;
        $this->owner = $owner;
        $this->name = $name;
        $this->author = $author;
        $this->data = $data;
    }

    public function getid()
    {
        return $this->id;
    }

    public function getname()
    {
        return $this->name;
    }

    public function getowner()
    {
        return $this->owner;
    }

    public function getownerid()
    {
        return $this->idowner;
    }

    public function getauthor()
    {
        return $this->author;
    }

    public function getdata()
    {
        return $this->data;
    }

    public function play()
    {
        return "playing";
    }

    public function stop()
    {
        return "stopping";
    }

    public function load_song()
    {
        return "loading";
    }
}


//class songfinder
//{
//    function __construct()
//    {
//        if ($perm->see_all == 1) {
//            $stmt = $conn->prepare("SELECT songs.id_songs, users.id_user AS id_owner, users.username AS song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_user=songs.id_owner");
//        } else {
//            $stmt = $conn->prepare("SELECT songs.id_songs, users.id_user AS id_owner, users.username AS song_owner, songs.song_name, songs.song_author, songs.song_data FROM songs INNER JOIN users ON users.id_user=songs.id_owner WHERE public=1 OR id_owner=?");
//        }
//        $stmt->bindValue(1, $id_user);
//        $stmt->execute();
//        $songs = array();
//        while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
//            $songs[$result->id_songs] = new song($result->id_songs, $result->id_owner, $result->song_owner, $result->song_name, $result->song_author, $result->song_data);
//        }
//    }
//}