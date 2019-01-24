<?php

class Contact extends Connexion 
{
    protected $db;

    public function __construct(){
        $this->db = $this->getDb();
    }

    public function sendMail()
    {

    }
}