<?php

class AuthController {
    const SESSION_VAR = "UserID";

    private $user = null;
    private $mysqli = null;

    public function __construct($oMysqliConn) {
        if($oMysqliConn)instanceof mysqli)
            throw new Exception("Private profide a mysqli object");
        $this->mysqli = $oMysqliConn;

        if(isset($_SESSION[self::SESSION_VAR])) {
            $bSuccess = $this->verifyUser($_SESSION[self::SESSION_VAR]);
            if(!$bSuccess)
                unset($_SESSION[self::SESSION_VAR]);
        }         

    }

    public function verifyUser($iUserID) {
        // Check is userId is nummeric
        if(!is_numeric($iUserID)) {
            return false;
        } 

        //Query the database;
        
        $sQuery = "
            SELECT 
              id_user AS id, 
              username,
              nickname
            FROM users 
            WHERE id = '".$this->mysqli->real_escape_string($iUserID)."'
            ";
        $oResult = $this->mysqli->query($sQuery);
        if($oResult->num_rows != 1) {
            return false;
        }
        
        $this->user = $oResult->fetch_object('User');
        return true;
 
    } 

    public function getUser() {
        return $this->user;
    }

    public function login($username, $password) {

        $sQuery = "
            SELECT 
                id_user,
                password
            FROM users 
            WHERE username = '".$this->mysqli->real_escape_string($username)."'
            ";
        $oResult = $this->mysqli->query($sQuery);
        if($oResult->num_rows != 1) {
            return false;
        }
        
        $aRow = $oResult->fetch_assoc();
        $bSuccess = password_verify($password, $aRow['password']);

        if(!$bSuccess)
            return false;

        $_SESSION[self::SESSION_VAR] = $aRow['id_user'];
        return true;
    }

}

class User {
    public $id;
    public $username;
    public $password;

}
