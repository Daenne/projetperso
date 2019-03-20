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

    public function postArticleWithPicture ($title, $content, $image)
    {
        $article = $this->db->prepare('INSERT INTO articles(title, content, date_create, image) VALUES (?, ?, NOW(), ?)');
        $newArticle = $article->execute(array($title, $content, $image));
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
        //while($row = $request->fetch(PDO::FETCH_ASSOC))
        //{

        //    $id = $row['id'];
        //    $title = $row['title'];
        //    $content = $row['content'];
        //    $date_create = $row['date_create'];
        //    $image = $row['image'];

        //return $row;
        //} 

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
            $image = $row['image'];

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

    public function updateArticleWithPicture($id, $title, $content, $image)
    {
        $request = $this->db->prepare('UPDATE articles SET title = ?, content = ?, image = ? WHERE id =' . $id);
        $updateArticle = $request->execute(array($title, $content, $image));
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

    public function getAllComments()
    {
        $sql = 'SELECT * FROM comments WHERE warning = 1 ORDER BY warning DESC';
        $request = $this->db->prepare($sql);
        $request->execute();
        return $request;
    }

    public function getComments($id) 
    {
        $comments = $this->db->prepare('SELECT id, articleid, author, comment, DATE_FORMAT(date_create, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE articleid = ? ORDER BY date_create DESC');
        $comments->execute(array($id));
        return $comments;
    }

        //UPDATE

    public function warningComment($id)
    {
        $request = $this->db->prepare('UPDATE comments SET warning = 1 WHERE id =' . $id);
        $updateComment = $request->execute();
        return $updateComment;
    }

    public function validComment($id)
    {
        $request = $this->db->prepare('UPDATE comments SET warning = 0 WHERE id =:id');
        $request->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $updateComment = $request->execute();
        return $updateComment;
    }

        //DELETE

    public function deleteComment ($id) 
    {
        $request = $this->db->prepare('DELETE FROM comments WHERE id =:id');
        $request->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $deleteComment = $request->execute();
        return $deleteArticle;
    }
}