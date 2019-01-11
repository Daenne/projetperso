<?php

class ArticlesManager extends Connexion 
{
    protected $db;

    public function __construct(){
        $this->db = $this->getDb();
    }

    public function getArticles()
    {
        $sql = 'SELECT * FROM articles ORDER BY id DESC';
        $request = $this->db->prepare($sql);
        $request->execute();
        return $request;
    }

    public function getArticle($id)
    {
        $request = $this->db->prepare('SELECT * FROM articles WHERE id =:id');
        $request->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $request->execute();
        while($row = $request->fetch(PDO::FETCH_ASSOC))
        {

            $id = $row['id'];
            $title = $row['title'];
            $content = $row['content'];
            $date_create = $row['date_create'];
            $status = $row['status'];

        return $row;
        } 
    }

    public function getComments($id) 
    {
        $comments = $this->db->prepare('SELECT id, articleid, author, comment, DATE_FORMAT(date_create, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE articleid = ? ORDER BY date_create DESC');
        $comments->execute(array($id));
        return $comments;
    }
}