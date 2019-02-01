<?php

class ArticlesManager extends Connexion 
{
    protected $db;
    protected $articlesPerPage;

    public function __construct(){
        $this->db = $this->getDb();
        $this->articlesPerPage = 3;
    }

    //ARTICLES
        //CREATE
    public function postArticle($title, $content)
    {
        $article = $this->db->prepare('INSERT INTO articles(title, content, date_create, image) VALUES (?, ?, NOW(), 0)');
        $newArticle = $article->execute(array($title, $content));
        return $newArticle;
    }
        //READ

    public function getPagination()
    {
        $allArticlesReq = $this->db->query('SELECT * FROM articles ORDER BY id DESC');
        $allArticles = $allArticlesReq->rowCount();

        $allPages = ceil($allArticles/$this->articlesPerPage);

        return $allPages;
    }

    public function getArticles($currentPage)
    {
        $sql = 'SELECT * FROM articles ORDER BY id DESC LIMIT ' .($currentPage-1)*$this->articlesPerPage . ',' . $this->articlesPerPage;
        $request = $this->db->prepare($sql);
        $request->execute();

        return $request;
    }

    public function getLastArticles()
    {
        $sql = ('SELECT * FROM articles ORDER BY id DESC LIMIT 3');
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
            //$status = $row['status'];

        return $row;
        } 
    }

        //UPDATE

    public function updateArticle ($id, $title, $content) 
    {
        $request = $this->db->prepare('UPDATE articles SET title = ?, content = ? WHERE id =' . $id);
        $updateArticle = $request->execute(array($title, $content));
        return $updateArticle;
    }
        //DELETE

    public function deleteArticle ($id) 
    {
        $request = $this->db->prepare('DELETE FROM articles WHERE id = :id');
        $request->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $deleteArticle = $request->execute();
        return $deleteArticle;
    }

    //COMMENTS

        //CREATE

    public function postComment($articleid, $author, $comment) 
    {
        $comments = $this->db->prepare('INSERT INTO comments(articleid, author, comment, date_create, warning) VALUES (?, ?, ?, NOW(), 0)');
        $affectedLines = $comments->execute(array($articleid, $author, $comment));
        return $affectedLines;
    }
        //READ

    public function getComments($id) 
    {
        $comments = $this->db->prepare('SELECT id, articleid, author, comment, DATE_FORMAT(date_create, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE articleid = ? ORDER BY date_create DESC');
        $comments->execute(array($id));
        return $comments;
    }

        //UPDATE

        //DELETE
}