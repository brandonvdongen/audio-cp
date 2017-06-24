<?php

class database
{
    private $conn;
    private $user;
    private $pass;
    private $database;

    public function __construct()
    {
        $auth_config = parse_ini_file("auth.ini");
        $this->user = $auth_config["username"];
        $this->pass = $auth_config["password"];
        $this->database = $auth_config["database"];
        $this->conn = new PDO("mysql:host=localhost;dbname=$this->database", $this->user, $this->pass);
    }

    public function prepared_query($statement, $bindings=[])
    {
        $stmt = $this->conn->prepare($statement);
        foreach ($bindings as $i => $bind) {
            $stmt->bindValue(($i + 1), $bind);
        }
        $exec=$stmt->execute();
        if(!$exec){
            return false;
        }
        $output = array();
        while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
            $output[] = $result;
        }
        $count = count($output);
        if ($count == 1) {
            return $output[0];
        } else if ($count == 0) {
            return true;
        } else {
            return $output;
        }

    }
}

class auth
{
    const SESSION_VAR = "id_user";
    private $database;
    private $id_user;
    private $username;
    private $nickname;

    public function __construct()
    {

        $this->database = new database();
        if (isset($_SESSION[self::SESSION_VAR])) {
            $this->id_user = $_SESSION[self::SESSION_VAR];
            $this->verify_login();
        } else {
            unset($this->id_user);
            unset($_SESSION[self::SESSION_VAR]);
        }
    }

    public function verify_login()
    {
        if (!is_numeric($id = $this->id_user)) {
            return false;
        } else {
            $result = $this->database->prepared_query('SELECT id_user, username, nickname FROM users WHERE users.id_user=?', [$this->id_user]);
            if ($result) {
                $this->username = $result->username;
                $this->nickname = $result->nickname;
                return true;
            } else {
                return false;
            }
        }
    }

    public function login($username, $password)
    {
        $result = $this->database->prepared_query("SELECT * FROM users WHERE username=?", [$username]);
        if ($result) {
            if (password_verify($password, $result->password)) {
                $_SESSION[self::SESSION_VAR] = $result->id_user;
                $this->id_user = $result->id_user;
                $this->username = $result->username;
                $this->nickname = $result->nickname;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION[self::SESSION_VAR]);
    }

    public function get_permissions()
    {
        return $this->database->prepared_query("SELECT users.id_user, users.nickname, permissions.see_all, permissions.edit_all, permissions.remove_all FROM permissions INNER JOIN users ON users.id_user=permissions.id_permissions WHERE users.id_user=?", [$this->id_user]);
    }

    public function get_id()
    {
        if (isset($this->id_user)) {
            return $this->id_user;
        } else {
            return false;
        }

    }

    public function get_username()
    {
        return $this->username;
    }

    public function get_nickname()
    {
        return $this->nickname;
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

    public function get_id()
    {
        return $this->id;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_owner()
    {
        return $this->owner;
    }

    public function get_owner_id()
    {
        return $this->idowner;
    }

    public function get_author()
    {
        return $this->author;
    }

    public function get_data()
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

class songfinder
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