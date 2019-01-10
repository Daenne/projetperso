<?php

class AdminManager extends Connexion 
{
    protected $db;

    public function __construct(){
        $this->db = $this->getDb();
    }

    public function adminConnexion()
    {
        $result = $this->db->prepare('SELECT pseudo, password FROM members WHERE id = 1');
        $result->execute();
        $result = $result->fetch();
        return $result;
    }

    public function getAdminIndex()
    {
        $sql = 'SELECT * FROM articles ORDER BY id DESC';
        $request = $this->db->prepare($sql);
        $request->execute();
        return $request;
    }
}