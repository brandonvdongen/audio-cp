<?php

class Song
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
}