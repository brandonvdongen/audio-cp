<?php

class Database
{
    private $conn;
    private $user;
    private $pass;
    private $database;

    public function __construct()
    {
        $auth_config = parse_ini_file("../config/auth.ini");
        $this->user = $auth_config["username"];
        $this->pass = $auth_config["password"];
        $this->database = $auth_config["database"];
        $this->conn = new PDO("mysql:host=localhost;dbname=$this->database", $this->user, $this->pass);
    }

    public function prepared_query($statement, $bindings = [])
    {
        $stmt = $this->conn->prepare($statement);
        foreach ($bindings as $i => $bind) {
            $stmt->bindValue(($i + 1), $bind);
        }
        $exec = $stmt->execute();
        if (!$exec) {
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