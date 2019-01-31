<?php

class ArticlesController
{
    protected $manager;
    protected $newsletter;

    public function __construct() {

        $this->manager = new ArticlesManager();
        $this->newsletter = new Newsletter();
    }

    public function showArticles($params) 
    {
        $articlesList = $this->manager->getArticles();
        $pageTitle = 'Articles';
        

        $myView = new View('ArticlesView');
        $myView->render(array('articlesList' => $articlesList, 'pageTitle' => $pageTitle)); 
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
    //CREATE

    public function addComment($params) 
    {
      extract($params);
      $affectedLines = $this->manager->postComment($id, $author, $content);
      try
      {
        if ($affectedLines === false) {
            throw new Exception("<p>Impossible d'ajouter le commentaire. Retour à la page d'accueil <a href=\"index.php?action=blog\">ici</a></p>");
        }
        else {
            $myView = new View();
            $myView->redirect('article/'. $id);
        }
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      } 
    }

    //READ

    public function getComments($params)
    {
      //extract($params);
      $comments = $this->manager->getComments($params);
      return $comments;
    }




    public function subscribeNewsletter($params)
    {
      extract($params);

      $subscribe = $this->newsletter->addNewsletter($user_mail_newsletter);

      try
      {
        if ((isset($user_mail_newsletter)) && $subscribe === true) {

          $pageTitle = 'Succès';

          $myView = new View('successView');
          $myView->render(array('pageTitle' => $pageTitle));
        }
        else {

          throw new Exception("<p>Vous n'avez pas renseigné votre adresse mail</p>");
        }
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      }

    }

    public function unsubscribeNewsletter($params)
    {


    }

    public function sendNewsletter($params)
    {


    }

    //quand changement ou redirect myView->redirect('la page ou je veux redirect')
    
}