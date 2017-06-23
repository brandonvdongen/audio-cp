<?php

/**
 * Created by PhpStorm.
 * User: student
 * Date: 22-06-17
 * Time: 11:18
 */
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
        echo "playing...";
    }

    public function stop()
    {
        echo "stopping...";
    }
}