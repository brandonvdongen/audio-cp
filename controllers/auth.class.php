<?php

class AuthController {
    const SESSION_VAR = "UserID";

    private $user = null;
    private $mysqli = null;

    public function __construct($oMysqliConn) {
        if($hMySQLiConn instanceof mysqli)
            throw new Exception("Private profide a mysqli object");

        if(isset($_SESSION[self::SESSION_VAR])) {
            $this->verifyUser($_SESSION[self::SESSION_VAR]);
        }         

    }

    public function verifyUser($iUserID) {
        // Check is userId is nummeric
        if(!is_numeric($iUserID)) {
            unset($_SESSION[self::SESSION_VAR];
            return null;
        } 

        //Query the database;
        
        $sQuery = "
            SELECT 
              id_user as id, 
              username,
              nickname
            FROM users 
            WHERE id = '".$this->mysqli->real_escape_string($iUserID)."'
            ";
        $oResult = $this->mysqli->query($sQuery);
        if($oResult->num_rows != 1) {
            unset($_SESSION[self::SESSION_VAR];
            return;
        }
        
        $this->user = $oResult->fetch_object('User');
 
    } 

    public function getUser() {
        return $this->user;
    }

}

class User {
    public $id;
    public $username;
    public $password;

}
