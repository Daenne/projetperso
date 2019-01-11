<?php

class ArticlesController
{
    protected $manager;

    public function __construct() {

        $this->manager = new ArticlesManager();
    }

    public function showArticles($params) 
    {
        $articlesList = $this->manager->getArticles();
        

        $myView = new View('ArticlesView');
        $myView->render(array('articlesList' => $articlesList)); 
    }

    public function showOneArticle($params){

      try {
        extract($params);

          if (isset($id)) 
          {
            $article = $this->manager->getArticle($id);
            //$article = $article->fetch();
            $pageTitle = $article['title'];
            $comments = $this->getComments($id);

            $myView = new View('ArticleView');
            $myView->render(array('article' => $article, 'pageTitle' => $pageTitle, 'comments' => $comments));
          }
          else 
          {
            throw new Exception("<p>Aucun identifiant de billet envoyé. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
          }
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      } 
    }


    public function getComments($params)
    {
      //extract($params);
      $comments = $this->manager->getComments($params);
      return $comments;
    }

    //quand changement ou redirect myView->redirect('la page ou je veux redirect')
    
}